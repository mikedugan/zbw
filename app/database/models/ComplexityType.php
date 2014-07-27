<?php

class ComplexityType extends Eloquent
{
    protected $fillable = ['type'];
    protected $table = '_complexity_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
}
