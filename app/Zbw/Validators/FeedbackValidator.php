<?php  namespace Zbw\Validators; 

class FeedbackZbwValidator extends ZbwValidator
{
    protected $rules;
    public function __construct()
    {
        $cids = \Zbw\Base\Helpers::getCids(true);
        $this->rules = [
            'controller' => 'in:' . $cids,
            'rating' => 'integer|max:5',
            'name' => 'alpha|max:50',
            'email' => 'email|max:50',
            'ip' => 'ip'
        ];
    }
} 
