<?php
namespace App\Validation\Exceptions;

use \Respect\Validation\Exceptions\ValidationException;

class SamePasswordCheckException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => 'Your new password may not be the same as the old',
        ),
    );    
}
