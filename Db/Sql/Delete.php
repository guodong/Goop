<?php
namespace Goop\Db\Sql;

use Goop\Db\Pdo\Statement;

class Delete extends Statement
{
	
	public function execute()
	{
		$this->prepare();
		$this->bindParam();
		$r = $this->resource->execute();
		if (defined("DEBUG")) $this->resource->debugDumpParams();
		return $r;
	}
}