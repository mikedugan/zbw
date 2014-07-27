<?php

class SubscriptionType extends \Eloquent {
    protected $fillable = ['value'];
    public $timestamps = false;
    protected $table = '_subscription_types';
    static $rules = [
        'value' => 'required'
    ];
}
