<?php

class SubscriptionType extends \Eloquent {
    protected $fillable = ['value'];
    public $timestamps = false;
    protected $table = '_subscription_types';
}
