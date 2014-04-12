<?php  namespace Zbw\Validators; 

use Zbw\Helpers;

class PrivateMessageZbwValidator extends ZbwValidator
{
    public $rules;
    public function __construct()
    {
        $cids = Helpers::getCids(true);
        $this->rules =
            [
                'from' => "in:$cids",
                'to' => "in:$cids",
                'subject' => 'max:60'
            ];
    }
} 
