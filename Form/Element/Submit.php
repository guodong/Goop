<?php
namespace Goop\Form\Element;
class Submit extends \Goop\Form\Element
{
	public function render()
	{
		$class = empty($this->_class) ? '' : 'class="'.$this->_class.'"';
		$str = '<dd><input type="submit" name="'.$this->_name.'" value="'.$this->_label.'" '.$class.'/></dd>';
		return $str;
	}
}