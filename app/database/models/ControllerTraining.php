<?php

class ControllerTraining extends Eloquent {
	protected $guarded = ['cid', 'sid'];
	protected $table = 'controller_training';
	public static $rules = [
        'cid' => '',
        'sid' => '',
        'session_date' => 'date',
        'weather' => 'integer|max:4',
        'complexity' => 'integer|max:4',
        'workload' => 'integer|max:4',
	];

    public function __construct()
    {
        $cids = \Zbw\Helpers::getCids(true);
        $this->rules['cid'] = 'in:' . $cids;
        $this->rules['sid'] = 'in:' . $cids;
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

    //statics
    public static function recentReports($n)
    {
        return ControllerTraining::with(['student', 'staff', 'location'])
            ->latest('session_date')->take($n)->get();
    }
}
