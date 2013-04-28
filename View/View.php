<?php
namespace Goop\View;
use Goop\Config;

use Goop\AbstractView;
class View extends AbstractView
{

	private $_disableView = false;

	private $_disableLayout = false;

	public $_layout = null;
	
	public static $instance;
	
	public static function getInstance()
	{
		if (NULL === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function __construct()
	{
		$this->_layout = \Goop\View\Layout::getInstance();
		if (Config::get(Config::CONFIG_VIEW) !== NULL){
			$config = Config::get(Config::CONFIG_VIEW);
			$this->_disableLayout = $config->getDisableLayout();
		}
	}

	/**
	 * 是否禁用视图
	 * @param bool $flag
	 */
	public function disableView($flag = TRUE)
	{
		$this->_disableView = (bool) $flag;
	}

	/**
	 * 是否禁用layout
	 * @param bool $flag
	 */
	public function disableLayout($flag = TRUE)
	{
		$this->_disableLayout = (bool) $flag;
	}

	public function render()
	{
		if (! $this->_disableView) {
			require $this->_scriptPath . $this->_scriptName;
			if (! $this->_disableLayout) {
				$content = ob_get_contents();
				$this->_layout->setContent($content);
				ob_clean();
				$this->_layout->render();
			}
		}
	}

	public function getLayout()
	{
		return $this->_layout;
	}

	public function setLayoutScriptPath($path)
	{
		$this->getLayout()->setScriptPath($path);
		return $this;
	}

	public function inc($file, $path = NULL)
	{
		return null == $path ? include_once $this->getLayout()->getScriptPath() .
				 $file . '.phtml' : include_once $path . $file . '.phtml';
			}
		}