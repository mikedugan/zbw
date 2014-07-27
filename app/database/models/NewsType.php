<?php

class NewsType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_news_types';
    public $timestamps = false;
    static $rules = [
      'value' => 'required'
    ];
}
