<?php

class TrainingSession extends Eloquent {
	protected $guarded = ['cid', 'sid'];
	protected $table = 'controller_training_sessions';
	public $rules;

    public function __construct()
    {
        $cids = \Zbw\Helpers::getCids(true);

    }

    //scopes
    public function scopeOlder($query, $date)
    {
        return $query->where('session_date', '<', $date);
    }

    public function scopeNewer($query, $date)
    {
      return $query->where('session_date', '>', $date);
    }

    //relations
    public function student()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    public function staff()
    {
        return $this->belongsTo('User', 'sid', 'cid');
    }

    public function location()
    {
        return $this->hasOne('TrainingFacility', 'id', 'facility');
    }

    public function weatherType()
    {
        return $this->hasOne('WeatherType', 'id', 'weather');
    }

    public function complexityType()
    {
        return $this->hasOne('ComplexityType', 'id', 'complexity');
    }

    public function workloadType()
    {
        return $this->hasOne('WorkloadType', 'id', 'workload');
    }

    //statics
    public static function recentReports($n)
    {
        return TrainingSession::with(['student', 'staff', 'location'])
            ->orderBy('created_at')->limit($n)->get();
    }
}
