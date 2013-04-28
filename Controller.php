<?php
namespace Goop;
use Goop\View\View;

class Controller
{
	public $view;
	protected function init(){}
	
	public function __construct()
	{
		$this->view = View::getInstance();
		$this->init();
	}
	
	/**
	 * @return \Goop\Request
	 */
	public function getRequest()
	{
		return Request::getInstance();
	}
    
	static public function redirect($url)
    {
        header("Location: $url");
    }
	
}