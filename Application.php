<?php
namespace Goop;
use Goop\Router\Rule;

class Application
{
	private $config;
	private $configPath;

	private $request;

	private $response;

	public function autoload($class)
	{
		if(substr($class, 0, 1) === "\\")
			$class = substr($class, 1);
		if(substr($class, 0, 4) === "Goop"){
			$p = str_replace("\\", DIRECTORY_SEPARATOR, substr($class, 5)) . '.php';
			$path = PATH_GOOP.$p;
			return require_once $path;
		}
		$incpaths = get_include_path();
		$arr = explode(PATH_SEPARATOR, $incpaths);
		
		// transform the namespace path to dir path
		$p = str_replace("\\", DIRECTORY_SEPARATOR, $class) . '.php';
		//echo $p;
		foreach ($arr as $v) {
			$path = $v . DIRECTORY_SEPARATOR . $p;
			if (file_exists($path)) {
				return require_once $path;
				break;
			}
		}
		return false;
	}

	public function __construct($configPath = NULL)
	{
		spl_autoload_register(array(__CLASS__, 'autoload'));
		if (NULL !== $configPath) {
			$this->setConfigPath($configPath);
		}
		$this->init();
	}

	public function run()
	{
		if (empty($this->configPath)) die("config file not found!");
		$router = Router::getInstance();

		$router->route();
		
		ob_start();
		$cn = 'Module\\'.ucfirst($router->getModuleName()).'\\Controller\\'.ucfirst($router->getControllerName()).'Controller';
		$c = new $cn();
		$an = $router->getActionName().'Action';
		$c->$an();
		$c->view->render();
		$content = ob_get_clean();
		
		$this->response->append($content);
		$this->response->send();
	}

	private function init()
	{
		$this->request = Request::getInstance();
		$this->response = Response::getInstance();
		require $this->configPath;
	}
	
	public function setConfigPath($path)
	{
		$this->configPath = $path;
	}
}
