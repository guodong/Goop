<?php
namespace Goop\Db;
use Goop\Db;

use Goop\Config;

use Goop\Db\Sql;
class Table
{

	protected $_name = NULL;

	protected $_pk = array('id');
	
	private $prefix = "";

	public function __construct($tableName)
	{
		$this->_name = $tableName;
		$dbConfig = Config::get(Config::CONFIG_DB);
		//$this->prefix = $dbConfig->getPrefix();
	}
	
	private function getTableName()
	{
		return $this->prefix.$this->_name;
	}
	
	public function getColumns()
	{
		$dbh = Db::getInstance()->getHandler();
		$q = $dbh->prepare("DESCRIBE ".$this->_name);
		$q->execute();
		return $q->fetchAll(\PDO::FETCH_COLUMN);
	}

	/**
	 * 
	 * @param array $param
	 */
	public function fetchAll($sql = "", $params = NULL)
	{
		$sql = "SELECT * FROM `".$this->getTableName()."` ".$sql;
		if (!is_array($params)) $params = array($params);
		$select = \Goop\Db\Sql::factory(\Goop\Db\Sql::SQL_SELECT, $sql, $params);
		$rows = $select->execute();
		return $rows;
	}

	public function insert($data)
	{
		$pmarr = array();
		foreach ($data as $k => $v) {
			$pmarr[] = $v;
		}
		
		$keys = array_keys($data);
		$fields = implode(', ', $keys);
		
		$sigarr = array();
		foreach ($keys as $v) {
			$sigarr[] = "?";
		}
		$sigstr = implode(', ', $sigarr);
		
		$vals = array_values($data);
		$values = implode(', ', $vals);
		$sql = "INSERT INTO ".$this->getTableName()." ($fields) VALUES ($sigstr)";
		$insert = \Goop\Db\Sql::factory(Sql::SQL_INSERT, $sql, $pmarr);
		if ($insert->execute()){
			return $insert->getLastInsertId();
		} else {
			return false;
		}
	
	}

	public function find($pkarray)
	{
		$this->_select = new \Goop\Db\Select();
		$this->_select->setFrom($this->getName())
			->setWhere($pkarray);
		$result = $this->_select->execute();
		if (!empty($result)) {
			return $result[0];
		} else {
			return null;
		}
	}

	public function update($condition = NULL, $data)
	{
		$karr = array();
		$pmarr = array();
		
		foreach ($data as $field => $v) {
			$karr[] = $field . " = ?";
			$pmarr[] = $v;
		}
		$kstr = implode(', ', $karr);
		
		$cond = "";
		if (NULL !== $condition) {
			$keys = array_keys($condition);
			$key = $keys[0];
			$cond = $key;
			$pmarr = array_merge($pmarr, $condition[$key]);
		}
		$sql = "UPDATE ".$this->getTableName()." SET " . $kstr . " ". $cond;
		
		$update = \Goop\Db\Sql::factory(Sql::SQL_UPDATE, $sql, $pmarr);
		return $update->execute();
	}

	public function delete($condition = NULL)
	{
		$pmarr = array();
		if (NULL !== $condition) {
			$keys = array_keys($condition);
			$key = $keys[0];
			$pmarr = $condition[$key];
		}
		$where = isset($key) ? $key : null;
		
		$sql = "DELETE FROM `".$this->getTableName()."`" . $where;
		
		$delete = \Goop\Db\Sql::factory(\Goop\Db\Sql::SQL_DELETE, $sql, $pmarr);
		$r = $delete->execute();
		return $r;
	}
}