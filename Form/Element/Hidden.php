<?php
namespace Goop\Form\Element;
class Hidden extends \Goop\Form\Element
{
	
	public function render()
	{
		//$err = $this->_message ? "<span class=\"error\">$this->_message</span>" : '';
		$str = "";
		$str .= "<input type=\"hidden\" name=\"$this->_name\" value=\"$this->_value\"/>";
		return $str;
	}
}