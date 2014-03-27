<?php  namespace Zbw\Validators; 

class NewsValidator extends ZbwValidator
{
    protected $rules;
    public function __construct() {
        $this->rules =
        [
            'news_type' => 'integer|max:4',
            'audience' => 'integer|max:4',
            'title' => 'max:60',
            'starts' => 'date',
            'ends' => 'date'
        ];
    }
}
