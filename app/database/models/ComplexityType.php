<?php

class ComplexityType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_complexity_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
}
