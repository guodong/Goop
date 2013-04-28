<?php
namespace Goop;
use Goop\Model\Payload;

abstract class Model
{

	/**
	 * 映射操作类
	 */
	private $_mapper = NULL;

	private $_mapperName;

	protected $_tableName;

	protected $_refArr = array();

	protected $_fields = array();

	protected $tbFields = array();

	/**
	 * 可以之间用一个数组为model赋值初始化，也可以用数字查找数据库中对应id的类
	 * 
	 * @param array|object|int $options        	
	 */
	public function __construct ($options = NULL)
	{
		if (is_array($options) || is_object($options)) {
			$this->setOptions($options);
		} elseif (is_numeric($options)) {
			$this->find($options);
		}
	}

	public function __get ($name)
	{
		if (! array_key_exists($name, $this->_fields)) {
			return $this->getRefObject($name);
		}
		return $this->_fields[$name];
	}

	public function __set ($key, $value)
	{
		$this->_fields[$key] = $value;
	}

	public function __unset ($name)
	{
		if (isset($this->_fields[$name])) {
			unset($this->_fields[$name]);
		}
	}

	private function getRefObject ($name)
	{
		foreach ($this->_refArr as $k => $v) {
			if ($name === $k) {
				$mn = "\\Model\\" . $v['class'];
				$this->_fields[$name] = new $mn($this->_fields[$v['id']]);
				
				break;
			}
		}
		return isset($this->_fields[$name])?$this->_fields[$name]:null;
	}

	public function setOptions ($options)
	{
		if (! $options) {
			return NULL;
		}
		if (is_object($options))
			$options = get_object_vars($options);
		$this->_fields = $options;
		foreach ($options as $k=>$v){
			if (property_exists($this, $k))
				$this->$k = $v;
		}
		return $this;
	}

	public function toArray ()
	{
		return $this->_fields;
	}

	private function getTableName ()
	{
		if (empty($this->_tableName)) {
			$class = get_class($this);
			$arr = explode('\\', $class);
			$tn = array_pop($arr);
			$this->_tableName = strtolower($tn);
		}
		return $this->_tableName;
	}

	private function getMapper ()
	{
		if (NULL === $this->_mapper) {
			$class = get_class($this);
			$arr = explode('\\', $class);
			$mn = '\\Mapper\\' . array_pop($arr);
			if (class_exists($mn)) {
				$this->_mapper = new $mn($this->getTableName());
			} else {
				$this->_mapper = new \Goop\Mapper($this->getTableName());
			}
		}
		return $this->_mapper;
	}

	/**
	 * ******************→_→ 栋哥专用分割线 ←_← *******************
	 */
	public function find ($sql = "", $params = array())
	{
		if (! is_string($sql) && ! is_numeric($sql)) {
			die("find function cannot handle array sql");
		}
		return $this->getMapper()->find($sql, $params, $this);
	}

	public function save ()
	{
		return $this->getMapper()->save($this);
	}

	public function update ($condition = NULL)
	{
		return $this->getMapper()->update($condition, $this);
	}

	public function delete ($condition = NULL)
	{
		return $this->getMapper()->delete($condition, $this);
		if (null == $condition)
			return $this->getMapper()->delete($this);
		return $this->getMapper()->delete($condition);
	}

	public function fetchAll ($sql = "", $params = array())
	{
		if (! is_string($sql)) {
			die("fetchAll function cannot handle array sql");
		}
		return $this->getMapper()->fetchAll($sql, $params, $this);
	}
}