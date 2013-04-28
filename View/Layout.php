<?php
namespace Goop\View;
use Goop\AbstractView;

class Layout extends AbstractView
{

	protected $_scriptName = 'layout.phtml';

	private static $_instance = NULL;

	public static function getInstance()
	{
		if (null == self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}



	public function render()
	{
		include $this->_scriptPath . $this->_scriptName;
	}

	public function setContent($content)
	{
		$this->_contents['default'] = $content;
	}

	public function inc($file, $path = NULL)
	{
		if (NULL === $path) {
			return require_once $this->_scriptPath . $file . '.phtml';
		} else {
			return require_once $path . $file . '.phtml';
		}
	}
}