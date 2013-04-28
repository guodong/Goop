<?php
namespace Goop;

use Goop\Lib\Singleton;


class Config extends Registry implements Singleton
{

	const CONFIG_DB = "Db";
	const CONFIG_VIEW = "View";

	private static $instance = NULL;

	public static function getInstance()
	{
		if (NULL === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * set the global config by factory function
	 * 
	 * @param string $name the class name in Goop/Config
	 * @param array $data
	 */
	public static function factorySet($name, array $data)
	{
		$instance = self::getInstance();
		$configClass = "\\Goop\\Config\\" . $name;
		$configObj = new $configClass($data);
		$instance::set($name, $configObj);
	}
}