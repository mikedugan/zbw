<?php

use Zbw\Validators\BaseValidator;

class BaseModel extends Eloquent {

    private $errors;
    private $validator;

    public function __construct()
    {
        $this->validator = new BaseValidator(get_class($this));
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
             return false;
          });
        static::saving(function($model)
        {
            return false;
        });
    }


    public function getErrors()
    {
        return $this->errors;
    }

} 
