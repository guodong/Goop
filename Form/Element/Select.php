<?php
namespace Goop\Form\Element;
class Select extends \Goop\Form\Element
{
	private $_options = array();
	
	public function addOption(\Goop\Form\Element\Select\Option $option)
	{
		$this->_options[] = $option;
	}
	
	public function render()
	{
		$str = "<dt>$this->_label</dt>";
		$str .= "<dd><select name=\"$this->_name\">";
		foreach ($this->_options as $v) {
			$sl = $v->isSelected() ? 'selected="selected"' : '';
			$str .= "<option $sl value=\"{$v->getValue()}\">{$v->getText()}</option>";
		}
		$str .= "</select></dd>";
		return $str;
	}
}