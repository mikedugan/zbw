<?php  namespace Zbw\Validators; 
use Zbw\Helpers;
class TrainingSessionValidator extends ZbwValidator {
    static $rules = [
        'cid' => "in: ",
        'sid' => 'in:',
        'session_date' => 'date',
        'weather' => 'integer|between:1,5',
        'complexity' => 'integer|between:1,5',
        'workload' => 'integer|between:1,3',
    ];
}
