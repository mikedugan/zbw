<?php  namespace Zbw\Validators; 
use Zbw\Helpers;
class TrainingSessionValidator extends ZbwValidator {
    static $rules = [
        'cid' => "in: ",
        'sid' => 'in:',
        'session_date' => 'date',
        'weather' => 'integer|max:4',
        'complexity' => 'integer|max:4',
        'workload' => 'integer|max:4',
    ];
}
