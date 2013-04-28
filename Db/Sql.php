<?php
namespace Goop\Db;

abstract class Sql
{

	const SQL_SELECT = "Select";

	const SQL_INSERT = "Insert";

	const SQL_UPDATE = "Update";

	const SQL_DELETE = "Delete";

	private static $handler;

	public static function factory($type, $sql, $params = array())
	{
		$class = '\\Goop\\Db\\Sql\\' . $type;
		self::$handler = new $class($sql, $params);
		return self::$handler;
	}

	

}