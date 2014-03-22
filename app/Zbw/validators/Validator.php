<?php  namespace Zbw\validators; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator as V;

class Validator
{
    protected $errors;
    public $valid;
    public function __construct($input, Model $type)
    {
        $validator = V::make($input, $type->rules);
        $this->valid = $validator->fails();
        $this->errors = $this->valid ? $validator->messages() : "";
    }

    public function errors()
    {
        return $this->errors;
    }
} 
