<?php

/**
 * SubscriptionType
 *
 * @property integer $key
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\SubscriptionType whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\SubscriptionType whereValue($value)
 */
class SubscriptionType extends \Eloquent {
    protected $fillable = ['value'];
    public $timestamps = false;
    protected $table = '_subscription_types';
    static $rules = [
        'value' => 'required'
    ];
}
