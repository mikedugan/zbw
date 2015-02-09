<?php

class TsKey extends Eloquent
{
    protected $guarded = ['id','created_at','updated_at'];
    protected $table = 'zbw_tskeys';

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public static function getTsKey($key)
    {
        return self::where('ts_key', $key)
            ->where('used', false)
            ->where('expires', '>', \Carbon::now())
            ->with('user')->first();
    }
}
