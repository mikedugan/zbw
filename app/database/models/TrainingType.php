<?php

class TrainingType extends Eloquent
{
    protected $fillable = ['type'];
    protected $table = '_training_types';
    public $timestamps = false;
    static $rules = [
      'value' => 'required'
    ];
}
