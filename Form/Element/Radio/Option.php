<?php
namespace Goop\Form\Element\Radio;
class Option
{
	private $_value;
	private $_text;
	private $_checked = FALSE;
	
	public function __construct($text, $value)
	{
		$this->_value = $value;
		$this->_text = $text;
	}
	
	public function setValue($value)
	{
		$this->_value = $value;
		return $this;
	}
	
	public function getValue()
	{
		return $this->_value;
	}
	
	public function setText($text)
	{
		$this->_text = $text;
		return $this;
	}
	
	public function getText()
	{
		return $this->_text;
	}
	
	public function setChecked($flag = TRUE)
	{
		$this->_checked = $flag;
		return $this;
	}
	
	public function isChecked()
	{
		return $this->_checked;
	}
}