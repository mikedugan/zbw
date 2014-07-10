<?php  namespace Zbw\Validators;

class PrivateMessageValidator extends ZbwValidator
{
    static $rules = [
        'from' => "integer",
        'to' => "integer",
        'subject' => 'max:60'
    ];
} 
