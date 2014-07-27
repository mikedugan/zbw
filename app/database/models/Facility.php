<?php 

class Facility extends BaseModel {
    public $timestamps = false;
    protected $table = '_facilities';
    protected $fillable = ['value'];
    static $rules = [
        'value' => 'required'
    ];
} 
