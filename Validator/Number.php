<?php
namespace Goop\Validator;
class Number extends \Goop\Validator
{
	public function isValid($value)
	{
		$pattern = '/[^0-9]/';
		$tmp = preg_replace($pattern, '', (string) $value);
		return $value === $tmp;
	}
}