<?php
namespace Goop\Form;
abstract class Element
{
	protected $_id;
	protected $_name;
	protected $_required = FALSE;
	protected $_value;
	protected $_label;
	protected $_validators = array();
	protected $_message;
	protected $_class;	//css样式
	
	const FORM_TEXT = "Text";
	const FORM_PASSWORD = "Password";
	const FORM_ANY = "Any";
	
	/**
	 * create form elements
	 * @param string $type
	 * @param string $param spec form name
	 * @return \Goop\Form\Element
	 */
	public static function factory($type, $param)
	{
		$class = '\\Goop\\Form\\Element\\' . $type;
		$handler = new $class($param);
		return $handler;
	}
	
	public function __construct($name = "")
	{
		$this->_name = $name;
	}
	
	public function setId($id)
	{
		$this->_id = $id;
		return $this;
	}
	
	public function getName()
	{
		return $this->_name;
	}
	
	public function setValue($val)
	{
		$this->_value = $val;
		return $this;
	}
	
	public function setRequired($flag = TRUE)
	{
		if ($flag) {
			$vd = new \Goop\Validator\Required();
			$this->_validators[] = $vd;
		}
		return $this;
	}
	
	public function setLabel($label)
	{
		$this->_label = $label;
		return $this;
	}
	
	public function setClass($class)
	{
		$this->_class = $class;
		return $this;
	}
	
	public function addValidator($validator)
	{
		$this->_validators[] = $validator;
		return $this;
	}
	
	public function isValid()
	{
		foreach ($this->_validators as $v) {
			
			if (!$v->isValid($this->_value)) {
				$this->_message = '校验失败，请检查';
				return false;
			}
		}
		return true;
	}
}