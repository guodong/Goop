<?php
namespace Goop;
use Goop\Lib\Singleton;

class Registry extends \ArrayObject implements Singleton
{

	private static $_instance = NULL;

	public static function getInstance()
	{
		if (null === self::$_instance) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public static function set($key, $value)
	{
		$instance = self::getInstance();
		$instance->offsetSet($key, $value);
		return $instance;
	}

	public static function get($index)
	{
		$instance = self::getInstance();
		
		if (! $instance->offsetExists($index)) {
			return null;
		}
		
		return $instance->offsetGet($index);
	}

	public static function isRegistered($key)
	{
		if (self::$_instance === null) {
			return false;
		}
		return self::$_instance->offsetExists($key);
	}
}