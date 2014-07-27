<?php 

class TrainingReport extends BaseModel
{
    protected $table = 'controller_training_reports';
    public $timestamps = false;
    static $rules = [
        'training_session_id' => 'integer',
        'brief' => 'integer|max:20',
        'runway' => 'integer|max:20',
        'weather' => 'integer|max:20',
        'coordination' => 'integer|max:20',
        'flow' => 'integer|max:20',
        'identity' => 'integer|max:20',
        'separation' => 'integer|max:20',
        'pointouts' => 'integer|max:20',
        'airspace' => 'integer|max:20',
        'loa' => 'integer|max:20',
        'phraseology' => 'integer|max:20',
        'priority' => 'integer|max:20',
        'markups' => '',
        'markdown' => '',
        'reviewed' => '',
        'ots' => 'integer',
        'positive_points' => 'integer',
        'negative_points' => 'integer',
        'modifier' => 'numeric'
    ];

    //relations
    public function training()
    {
        return $this->belongsTo('ControllerTraining', 'training_id', 'id');
    }
} 
