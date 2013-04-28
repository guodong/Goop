<?php
namespace Goop;
abstract class Validator
{
	private $_message = '校验失败，请检查';
	
	public function setMessage($message)
	{
		$this->_message = $message;
		return $this;
	}
	
	public function getMessage()
	{
		return $this->_message;
	}
}