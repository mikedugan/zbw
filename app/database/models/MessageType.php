<?php 

class MessageType extends Eloquent
{
    protected $fillable = ['value'];
    protected $table = '_message_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
} 
