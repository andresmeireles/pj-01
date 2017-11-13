<?php 
namespace App\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;
/**
* 
*/
class MatchesUserPasswordException extends ValidationException
{
	public static $defaultTemplates = array(
		self::MODE_DEFAULT => array(
			self::STANDARD => 'This isn\'t your current password!', 
		),
	);
}