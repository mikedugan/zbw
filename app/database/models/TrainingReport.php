<?php 

class TrainingReport extends Eloquent
{
    protected $table = 'controller_training_reports';
    public $timestamps = false;

    //relations
    public function training()
    {
        return $this->belongsTo('ControllerTraining', 'training_id', 'id');
    }
} 
