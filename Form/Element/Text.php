<?php
namespace Goop\Form\Element;
class Text extends \Goop\Form\Element
{
	
	public function render()
	{
		$err = $this->_message ? "<span class=\"error\">$this->_message</span>" : '';
		$str = "<dt>$this->_label</dt>";
		$str .= "<dd><input type=\"text\" name=\"$this->_name\" value=\"$this->_value\"/>$err</dd>";
		return $str;
	}
}