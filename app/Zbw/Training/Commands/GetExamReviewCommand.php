<?php  namespace Zbw\Training\Commands; 

class GetExamReviewCommand
{
    public $exam;

    public function __construct($exam)
    {
        $this->exam = $exam;
    }
} 
