<?php 

class TrainingReport extends Eloquent
{
    public $rules = [];
    protected $table = 'controller_reports';
    public $timestamps = false;

    //relations
    public function training()
    {
        return $this->belongsTo('ControllerTraining', 'training_id', 'id');
    }
} 
