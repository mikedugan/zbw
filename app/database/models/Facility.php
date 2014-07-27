<?php 

class Facility extends Eloquent {
    public $timestamps = false;
    protected $table = '_facilities';
    protected $fillable = ['value'];
    static $rules = [
        'value' => 'required'
    ];
} 
