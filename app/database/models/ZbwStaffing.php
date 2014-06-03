<?php

class ZbwStaffing extends Eloquent {
    protected $guarded = ['start', 'stop'];
    protected $table = 'zbw_staffing';
    protected $dates = ['start', 'stop'];
    public $rules = [
        'cid' => 'integer',
        'start' => 'date',
        'stop' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public static function frontPage()
    {
        return ZbwStaffing::where('stop', null)->with(['user'])->get();
    }
}
