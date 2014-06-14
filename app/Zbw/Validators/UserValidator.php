<?php  namespace Zbw\Validators;

class UserZbwValidator extends ZbwValidator
{
    protected $rules;
    public function __construct() {
        $this->rules =
            [
                'username' => 'alpha',
                'cid' => 'integer',
                'initials' => 'alpha|max:2',
                'first_name' => 'alpha|max:30',
                'last_name' => 'alpha|max:30',
                'email' => 'email|max:60',
                'rating_id' => 'alpha_num|max:3',
                'artcc' => 'alpha|max:3'
            ];
    }
} 
