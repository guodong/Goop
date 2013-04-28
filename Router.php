<?php
namespace Goop;
use Goop\Router\Rule;
class Router
{

	private $requestUri;

	private $moduleName = "Main";

	private $controllerName;

	private $actionName;

	private $rules = array();

	private static $instance = NULL;

	public static function getInstance($requestUri = NULL)
	{
		if (NULL === self::$instance) {
			self::$instance = new self($requestUri);
		}
		return self::$instance;
	}

	/**
	 * if the default param is NULL, it use the default $_SERVER[REQUEST_URI]
	 * @param string $requestUri
	 */
	public function __construct($requestUri = NULL)
	{
		if (NULL === $requestUri) {
			$r = Request::getInstance();
			$this->requestUri = $r->getServer("REQUEST_URI");
		} else {
			$this->requestUri = $requestUri;
		}
	}

	public function setRequestUri($requestUri)
	{
		$this->requestUri = $requestUri;
	}

	public function dispatch()
	{
	
	}

	public function addRule(Rule $rule)
	{
		$this->rules[] = $rule;
	}

	public function route()
	{
		$found = false;
		foreach ($this->rules as $rule) {
			if ($rule->isMatch($this->requestUri)) {
				$this->moduleName = $rule->getModuleName();
				$this->controllerName = $rule->getControllerName();
				$this->actionName = $rule->getActionName();
				$r = Request::getInstance();
				$r->addArgs($rule->getParams());
				foreach ($rule->getParams() as $v){
					$r->addArg(null, $v);
				}
				$found = true;
				break;
			}
		}
		if (! $found) { // if no matched rule, use the default router
			
			$arr = explode('?', $this->requestUri);
			$path = $this->trimBoth($arr[0], '/');
			preg_match(
					'#(?P<controller>\w+)?/?(?<action>\w+)?/?(?P<params>.*)?#', 
					$path, $matched);
			//print_r($matched);
			//$this->moduleName = "Main";
			$this->controllerName = $matched['controller'] ? $matched['controller'] : 'index';
			$this->actionName = $matched['action'] ? $matched['action'] : 'index';
			$arr = explode('/', $matched['params']);
			$r = Request::getInstance();
			$r->addArgs($arr);
		
		}
		$view = \Goop\View\View::getInstance();
		$view->setLayoutScriptPath(PATH_APPLICATION.'Module/'.$this->moduleName . '/layout/');
		$view->setScriptPath(PATH_APPLICATION.'Module/'.$this->moduleName.'/view/'.strtolower($this->controllerName).'/');
		$view->setScriptName($this->actionName.'.phtml');
	}

	public function getModuleName()
	{
		return $this->moduleName;
	}

	public function getControllerName()
	{
		return $this->controllerName;
	}

	public function getActionName()
	{
		return $this->actionName;
	}

	/**
	 * 
	 * @param unknown_type $str
	 * @param unknown_type $delimiter
	 */
	private function trimBoth($str, $delimiter)
	{
		$str = ($delimiter === substr($str, - 1)) ? substr($str, 0, - 1) : $str;
		$str = ($delimiter === substr($str, 0, 1)) ? substr($str, 1) : $str;
		return $str;
	}

}