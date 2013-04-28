<?php
namespace Goop\Db\Pdo;
class Statement
{

	private $pdo;

	/**
	 * the sql to be prepared and bind, with placeholder like ?
	 * @var string
	 */
	private $sql;

	/**
	 * the param array to be binded
	 * @var array
	 */
	private $params = array();

	/**
	 * the flag to ensure statement be prepared once
	 * @var bool
	 */
	//private $isPrepared = false;

	/**
	 * the prepared result
	 * @var \PDOStatement
	 */
	protected $resource;
	
	protected function getPdo()
	{
		return $this->pdo;
	}

	public function prepare()
	{
		$this->resource = $this->pdo->prepare($this->sql);
		if (false === $this->resource) {
			die("error where prepare sql");
		}
	}

	public function __construct($sql, array $params = array())
	{
		$this->pdo = \Goop\Db::getInstance()->getHandler();
		$this->sql = $sql;
		$this->params = $params;
	}

	protected function bindParam()
	{
		$i = 1;
		foreach ($this->params as &$v) { //must be used as reference
			$type = \PDO::PARAM_STR;
			
			$this->resource->bindParam($i, $v, $type);
			$i ++;
		}
	}
	
	public function execute()
	{
		$this->prepare();
		$this->bindParam();
		$r = $this->resource->execute();
		if (!$r){
			echo "\nPDOStatement::errorInfo():\n";
			$arr = $this->resource->errorInfo();
			print_r($arr);
			exit();
		}
		if (defined("DEBUG")) $this->resource->debugDumpParams();
		return $r;
	}
}