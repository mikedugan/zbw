<?php

class Subscription extends \Eloquent {
	  protected $fillable = [];
    protected $table = 'subscriptions';
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
