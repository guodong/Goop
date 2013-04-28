<?php
namespace Goop\Form\Element;
class Textarea extends \Goop\Form\Element
{
	public function render()
	{
		$str = "<dt>$this->_label</dt>";
		$str .= "<dd><textarea name=\"$this->_name\">$this->_value</textarea></dd>";
		return $str;
	}
}