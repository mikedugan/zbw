<?php

class Staffing extends BaseModel {
    protected $guarded = ['start', 'stop'];
    protected $table = 'zbw_staffing';
    protected $dates = ['start', 'stop', 'created_at', 'updated_at'];
    static $rules = [
        'cid' => 'cid',
        'position' => '',
        'start' => 'date',
        'stop' => 'date',
        'frequency' => ''
    ];

    public function getDates()
    {
        return ['start', 'stop', 'created_at', 'updated_at'];
    }

    public function user()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public static function frontPage()
    {
        return Staffing::where('stop', null)->with(['user'])->get();
    }

    public static function getDaysOfStaffing($days = 3)
    {
        return \Staffing::where('updated_at', '>', Carbon::now()->subDays($days))->get();
    }
}
