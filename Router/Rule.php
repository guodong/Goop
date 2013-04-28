<?php
namespace Goop\Router;
class Rule
{

	private $pattern;

	private $module;

	private $controller;

	private $action;

	private $params = array();

	/**
	 * the preg_match return array
	 * @var array
	 */
	private $matchArr = array();

	/**
	 * example param:
	 * array(
	 * 'pattern'=>'/user\/(?P<uid>\d+)/', 
	 * 'module'=>'default', 
	 * 'controller'=>'user', 
	 * 'action'=>'view', 
	 * 'params'=>array('uid'=>'$uid')
	 * )
	 * @param array $rule
	 */
	public function __construct($rule = array())
	{
		$this->pattern = $rule['pattern'];
		$this->module = $rule['module'];
		$this->controller = $rule['controller'];
		$this->action = $rule['action'];
		$this->params = isset($rule['params'])?$rule['params']:array();
	}

	/**
	 * must use it first, and the matchArr will be init,
	 * then functions like getModuleName() will work
	 * @param string $uri
	 */
	public function isMatch($uri)
	{
		$arr = explode('?', $uri);
		$path = $_SERVER['HTTP_HOST'].$this->trimBoth($arr[0], '/');
		if (preg_match($this->pattern, $path, $matched)) {
			$this->matchArr = $matched;
			//print_r($matched);
			return true;
		} else {
			return false;
		}
	}

	public function getModuleName()
	{
		if (0 === strpos($this->module, '$')) { //if the data is varible, get it from matchedArr
			$idx = substr($this->module, 1);
			return $this->matchArr[$idx];
		} else {
			return $this->module;
		}
	}

	public function getControllerName()
	{
		if (0 === strpos($this->controller, '$')) {
			$idx = substr($this->controller, 1);
			return isset($this->matchArr[$idx])?$this->matchArr[$idx]:'index';
		} else {
			return $this->controller;
		}
	}

	public function getActionName()
	{
		if (0 === strpos($this->action, '$')) {
			$idx = substr($this->action, 1);
			return isset($this->matchArr[$idx])?$this->matchArr[$idx]:'index';
		} else {
			return $this->action;
		}
	}

	/**
	 * get params from rule
	 * it will return a key=>value
	 * @return array
	 */
	public function getParams()
	{
		$arr = array();
		foreach ($this->params as $k => $v) {
			if (0 === strpos($v, '$')) {
				$idx = substr($v, 1);
				$val = isset($this->matchArr[$idx])?$this->matchArr[$idx]:null;
				$arr[$k] = $val;
			} else {
				$arr[$k] = $v;
			}
		}
		return $arr;
	}
	
	/**
	 * 
	 * @param unknown_type $str
	 * @param unknown_type $delimiter
	 */
	private function trimBoth($str, $delimiter)
	{
		$str = ($delimiter === substr($str, -1)) ? substr($str, 0, -1) : $str;
		$str = ($delimiter === substr($str, 0, 1)) ? substr($str, 1) : $str;
		return $str;
	}
}
