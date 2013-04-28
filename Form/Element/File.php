<?php
namespace Goop\Form\Element;
class File extends \Goop\Form\Element
{
	public function render()
	{
		$str = "<dt>$this->_label</dt>";
		$str .= "<dd><input type=\"file\" name=\"$this->_name\" value=\"$this->_value\" id=\"$this->_id\"/>";
		return $str;
	}
}