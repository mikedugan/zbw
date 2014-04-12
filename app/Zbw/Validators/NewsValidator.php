<?php  namespace Zbw\Validators; 

class NewsValidator extends ZbwValidator
{
     static $rules =
        [
            'news_type' => 'required|integer|between:1,5',
            'audience' => 'required|integer|between:1,3',
            'title' => 'required|max:60',
            'starts' => 'date',
            'ends' => 'date',
            'facility' => 'max:30',
        ];
}
