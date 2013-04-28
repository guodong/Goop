<?php
namespace Goop;
class Request
{

	private static $instance = NULL;

	private $_args = array();

	public static function getInstance()
	{
		if (NULL === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getPost($idx = NULL)
	{
		if (NULL === $idx) {
			return $_POST;
		} else {
			return $_POST[$idx];
		}
	}

	public function getGet($idx = NULL)
	{
		if (NULL === $idx) {
			return $_GET;
		} else {
			return $_GET[$idx];
		}
	}

	public function getServer($idx = NULL)
	{
		if (NULL === $idx) {
			return $_SERVER;
		} else {
			return $_SERVER[$idx];
		}
	}

	public function addArg($name = null, $val)
	{
		if (null !== $name) {
			$this->_args[$name] = $val;
		} else {
			$this->_args[] = $val;
		}
		return $this;
	}

	public function addArgs(array $args)
	{
		foreach ($args as $k => $v) {
			$this->addArg($k, $v);
		}
	}

	public function setArg($name = null, $val)
	{
		if (null !== $name) {
			$this->_args = array($name => $val);
		} else {
			$this->_args = (array) $val;
		}
		return $this;
	}

	public function getArg($index)
	{
		return isset($this->_args[$index]) ? $this->_args[$index] : null;
	}
}
