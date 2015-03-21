<?php

/**
 * Subscription
 *
 * @property integer $id
 * @property boolean $method
 * @property boolean $frequency
 * @property string $settings
 * @property integer $cid
 * @property integer $type
 * @property integer $type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \SubscriptionType $subscriptionType
 * @property-read \User $user
 * @property-read \$this->subscriptionType->value $parent
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereFrequency($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereSettings($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereCid($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Subscription whereUpdatedAt($value)
 * @method static \Subscription cid($cid)
 */
class Subscription extends \Eloquent {
	  protected $fillable = [];
    protected $table = 'subscriptions';
    static $rules = [
        'method' => 'integer',
        'frequency' => 'integer',
        'settings' => 'max:255',
        'cid' => 'cid|integer',
        'type' => 'integer',
        'type_id' => 'integer'
    ];


    public function scopeCid($q, $cid)
    {
        return $q->where('cid', $cid);
    }

    public function subscriptionType()
    {
        return $this->hasOne('SubscriptionType', 'key', 'type');
    }

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public function parent()
    {
        if(class_exists($this->subscriptionType->value))
            return $this->hasOne($this->subscriptionType->value, 'id', 'type_id');
        else return false;
    }
}
