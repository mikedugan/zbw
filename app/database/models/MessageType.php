<?php 

class MessageType extends BaseModel
{
    protected $fillable = ['value'];
    protected $table = '_message_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
} 
