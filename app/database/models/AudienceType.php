<?php

class AudienceType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_audience_types';
    public $timestamps = false;

    static $rules = [
        'value' => 'required'
    ];
}
