<?php
namespace Goop\Form\Element;
class Radio extends \Goop\Form\Element
{
	private $_options = array();
	
	public function addOption(\Goop\Form\Element\Radio\Option $option)
	{
		$this->_options[] = $option;
		return $this;
	}
	
	public function render()
	{
		$str = '<dt>'.$this->_label.'</dt><dd>';
		foreach ($this->_options as $k => $v) {
			$ck = $v->isChecked() ? 'checked="checked"' : '';
			$str .= "<input $ck type=\"radio\" name=\"$this->_name\" value=\"{$v->getValue()}\">{$v->getText()}";
		}
		$str .= '</dd>';
		return $str;
	}
}