<?php
namespace Goop\Config;

use Goop\Config;
class Db
{

	private $host;

	private $username;

	private $password;

	private $dbname;
	
	private $prefix;

	public function __construct(array $config)
	{
		$this->host = $config['host'];
		$this->username = $config['username'];
		$this->password = $config['password'];
		$this->dbname = $config['dbname'];
		$this->prefix = isset($config['prefix'])?$config['prefix']:"";
	}

	public function getHost()
	{
		return $this->host;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getDbname()
	{
		return $this->dbname;
	}
	
	public function getPrefix()
	{
		return $this->prefix;
	}
}