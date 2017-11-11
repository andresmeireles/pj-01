<?php
namespace App\Validation;

use \Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;
/**
* Validator class to use on ajax calls
*/
class ValidatorJson 
{
    protected $errors;
    
    public function validate($parameters, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($parameters[$field]);	
            } catch (NestedValidationException $e) {
                $this->errors['error'] = $e->getMessages();
            }
        }
        
        return $this;
    }
    
    public function failed()
    {
        return $this->errors;
    }
}