<?php
namespace Goop;
class Mapper
{

	private $table;

	public function __construct($tbname)
	{
		$this->table = new \Goop\Db\Table($tbname);
	}

	public function find($sql = "", $params = array(), \Goop\Model $model)
	{
		if (is_numeric($sql)) {
			$id = (int)$sql;
			$sql = 'WHERE id = ?';
			$params = array($id);
		}
		$mn = get_class($model);
		$rows = $this->fetchAll($sql, $params, new $mn());
		if (empty($rows)) {
			return NULL;
		} else {
			$model->setOptions($rows[0]->toArray());
			return $model;
		}
	}

	public function save(\Goop\Model $model)
	{
		$data = $model->toArray();
		//去除未赋值的变量，使用数据库默认值,保险起见，此种情况下update忽略未赋值成员，若要赋值为空，直接用下边的update函数
		//at the same time 对data和数据表字段做差集
		$colunms = $this->table->getColumns();
		foreach ($data as $key => $value) {
			if (null === $value || !in_array($key, $colunms)) unset($data[$key]);
		}
		
		
		if (($model->id)) {
			unset($data["id"]);
			return $this->table->update(array(
				'where id = ?' => array($model->id)), $data);
		}
		
		return $this->table->insert($data);
	
	}

	public function update($condition = NULL,\Goop\Model $model)
	{
		$data = $model->toArray();
		$colunms = $this->table->getColumns();
		foreach ($data as $key => $value) {
			if (!in_array($key, $colunms)) unset($data[$key]);
		}
		return $this->table->update($condition, $data);
	}

	public function delete($condition = NULL,\Goop\Model $model)
	{
		if (NULL === $condition && !empty($model->id)) {
			$condition = array('WHERE id = ?' => array($model->id));
		}
		return $this->table->delete($condition);
	}

	/**
	 * 
	 * @param array $param
	 * @param \Goop\Model $model used for get model class name
	 */
	public function fetchAll($sql = NULL, $params = array(),\Goop\Model $model)
	{
		$rows = $this->table->fetchAll($sql, $params);
		
		$mn = get_class($model);
		$items = array();
		foreach ($rows as $row) {
			$md = new $mn($row);
			$items[] = $md;
		}
		return $items;
	}
}