<?php  namespace Zbw\Validators; 

use Zbw\Helpers;

class PrivateMessageValidator extends ZbwValidator
{
    static $rules = [
        'from' => "integer",
        'to' => "integer",
        'subject' => 'max:60'
    ];
} 
