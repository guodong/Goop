<?php
namespace Goop\Validator;
class Email extends \Goop\Validator
{
	public function isValid($value)
	{
        if (preg_match('/^[_.0-9a-z-a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$/', $value)) {
            return true;
        }
        return false;
	}
}