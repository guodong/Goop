<?php

namespace Goop;

abstract class Form
{

	private $_elements = array();
	private $messages = array();

	public function __construct($id = NULL)
	{
		$this->init();
		if (NULL !== $id) {
			if (is_array($id)) {
				$this->fill($id);
			}
		}
	}

	public function fill($data)
	{
		foreach ($this->_elements as $v) {
			$v->setValue(isset($data[$v->getName()]) ? $data[$v->getName()] : '');
		}
	}

	public function addElement($element)
	{
		$this->_elements[] = $element;
		return $this;
	}

	protected function init()
	{
	}

	public function isValid($data = NULL)
	{
		if (NULL !== $data) $this->fill($data);
		foreach ($this->_elements as $v) {
			if (!$v->isValid()) {
				$this->messages[] = $v->getName();
				return false;
			}
		}
		return true;
	}
	
	public function getMessages()
	{
		return $this->messages;
	}
}