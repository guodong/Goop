<?php
namespace Goop;
use PDO;
use Goop\Lib\Singleton;

class Db implements Singleton
{

	private static $instance = NULL;

	/**
	 * the pdo handler
	 * @var unknown_type
	 */
	private $dbh;

	public function __construct()
	{
		$dbConfig = Config::get(Config::CONFIG_DB);
		try {
			$dbh = new PDO('mysql:host=' . $dbConfig->getHost() . ';dbname=' . $dbConfig->getDbname(), $dbConfig->getUsername(), $dbConfig->getPassword(), array(
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$this->dbh = $dbh;
		} catch (\PDOException $e) {
			echo "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}

	static function getInstance()
	{
		if (NULL === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function getHandler()
	{
		return $this->dbh;
	}
}