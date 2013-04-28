<?php
namespace Goop\Db\Sql;

use Goop\Db\Pdo\Statement;

class Insert extends Statement
{
	public function getLastInsertId()
	{
		return $this->getPdo()->lastInsertId();
	}
}