<?php
namespace Goop\Db\Sql;
use Goop\Db\Pdo\Statement;

class Select extends Statement
{
	/**
	 * this function will overwrite the parent's execute, becacuse it will return array data
	 * @see Goop\Db\Pdo.Statement::execute()
	 */
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
		$this->resource->setFetchMode(\PDO::FETCH_ASSOC);
		$rows = $this->resource->fetchAll();
		if (defined("DEBUG")) $this->resource->debugDumpParams();
		return $rows;
	} 
}