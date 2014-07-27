<?php

class TrainingType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_training_types';
    public $timestamps = false;
    static $rules = [
      'value' => 'required'
    ];
}
