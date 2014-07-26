<?php  namespace Zbw\Validators; 

use Illuminate\Validation\Validator;

class ZbwValidator extends Validator {

    public function validateCid($attribute, $value, $parameters)
    {
        $is_valid = false;
        $exists = false;
        $is_valid = ($value > 100000 && $value < 2000000) || $value == 100;
    }

    public function validateAirport($attributes, $value, $parameters)
    {
        if($parameters[0] === 'iata') {
            return preg_match('/[a-z]{3}/', strtolower($value));
        } else {
            return preg_match('/[a-z]{4}/', strtolower($value));
        }
    }
} 
