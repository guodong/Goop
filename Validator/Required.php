<?php
namespace Goop\Validator;
class Required extends \Goop\Validator
{
	public function isValid($value)
	{
		return !empty($value);
	}
}