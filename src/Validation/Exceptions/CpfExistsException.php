<?php
namespace App\Validation\Exceptions;

use \Respect\Validation\Exceptions\ValidationException;

class CpfExistsException extends ValidationException
{
    public static $defaultTemplates = array(
        self::MODE_DEFAULT => array(
            self::STANDARD => 'Esse cpf já esta cadastrado',
        ),
    );    
}
