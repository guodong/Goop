<?php
namespace Goop;

abstract class AbstractView
{

	protected $_scriptName;

	protected $_scriptPath;

	protected $_contents = array();

	public function getRequest ()
	{
		return Request::getInstance();
	}

	public function __get ($name)
	{
		return isset($this->_contents[$name]) ? $this->_contents[$name] : null;
	}

	public function __set ($name, $val)
	{
		$this->_contents[$name] = $val;
	}

	public function setScriptPath ($path)
	{
		$this->_scriptPath = $path;
		return $this;
	}

	public function getScriptPath ()
	{
		return $this->_scriptPath;
	}

	public function setScriptName ($name)
	{
		$this->_scriptName = $name;
	}

	/**
	 *
	 * @param string $str        	
	 * @return string
	 */
	public function html ($str)
	{
		return htmlspecialchars($str);
	}

	public function limitstr ($str, $length)
	{
		$encoding = 'utf-8';
		if (mb_strlen($str, $encoding) <= $length)
			return $str;
		$out = mb_substr($str, 0, $length, $encoding);
		return $out . '...';
	}

	public function url ($is_encode = FALSE)
	{
		if ($is_encode) {
			return urlencode(
					"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		}
		return "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}
}
