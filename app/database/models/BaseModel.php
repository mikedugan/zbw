<?php

/**
 * BaseModel
 *
 */
class BaseModel extends Eloquent {

    private $errors;

    public function __construct()
    {
        parent::__construct();
    }

    public function validate($model)
    {
        $validator = Validator::make($this->getAttributes(), static::$rules);
        if($validator->fails())
        {
            $this->errors = $validator->messages();

            return false;
        }
        return true;
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            return $model->validate($model);
        });
    }


    public function getErrors()
    {
        return $this->errors;
    }

} 
