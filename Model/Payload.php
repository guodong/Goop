<?php
namespace Goop\Model;
class Payload
{
	private $data = array();
	
	public function __construct($data = array())
	{
		$this->fields = $data;
	}
	
	public function __get($field)
	{
		return isset($this->data[$field])?$this->data[$field]:null;
	}
}