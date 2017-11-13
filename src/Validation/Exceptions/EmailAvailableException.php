<?php 
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;
/**
* 
*/
class EmailAvailableException extends ValidationException
{
	public static $defaultTemplates = array(
		self::MODE_DEFAULT => array(
			self::STANDARD => 'Email is already taken', 
		),
	);
}