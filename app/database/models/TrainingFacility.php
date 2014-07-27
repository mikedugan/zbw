<?php

class TrainingFacility extends BaseModel
{
    protected $table = "_training_facilities";
    public $timestamps = false;
    protected $guarded = [];
    static $rules = [
      'value' => 'required'
    ];
}
