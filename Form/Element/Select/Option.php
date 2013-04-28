<?php
namespace Goop\Form\Element\Select;
class Option
{
	private $_value;
	private $_text;
	private $_selected = FALSE;
	
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
	
	public function setSelected($flag = TRUE)
	{
		$this->_selected = $flag;
		return $this;
	}
	
	public function isSelected()
	{
		return $this->_selected;
	}
}