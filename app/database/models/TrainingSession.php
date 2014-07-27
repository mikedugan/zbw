<?php

class TrainingSession extends Eloquent {
	protected $guarded = ['cid', 'sid'];
	protected $table = 'controller_training_sessions';
	static $rules = [
      'cid' => 'cid|integer',
      'sid' => 'cid|integer',
      'session_date' => 'date',
      'weather_id' => 'integer',
      'complexity_id' => 'integer',
      'workload_id' => 'integer',
      'staff_comment' => '',
      'student_comment' => '',
      'is_ots' => 'integer',
      'facility_id' => 'integer',
      'brief_time' => 'integer',
      'position_time' => 'integer',
      'is_live' => 'integer',
      'training_type_id' => 'integer'
  ];

    //scopes
    /**
     * @param $query eloquent query
     * @param $date \Carbon object
     * @return Eloquent query
     */
    public function scopeOlder($query, $date)
    {
        return $query->where('session_date', '<', $date);
    }

    /**
     * @param $query eloquent query
     * @param $date \Carbon object
     * @return Eloquent query
     */
    public function scopeNewer($query, $date)
    {
      return $query->where('session_date', '>', $date);
    }

    //relations
    /**
     * @return User
     */
    public function student()
    {
        return $this->belongsTo('User', 'cid', 'cid');
    }

    /**
     * @return User
     */
    public function staff()
    {
        return $this->belongsTo('User', 'sid', 'cid');
    }

    public function trainingReport()
    {
        return $this->hasOne('TrainingReport', 'training_session_id', 'id');
    }

    /**
     * @return TrainingFacility
     */
    public function facility()
    {
        return $this->hasOne('TrainingFacility', 'id', 'facility_id');
    }

    public function trainingType()
    {
        return $this->hasOne('TrainingType', 'id', 'training_type_id');
    }

    /**
     * @return WeatherType
     */
    public function weatherType()
    {
        return $this->hasOne('WeatherType', 'id', 'weather_id');
    }

    /**
     * @return ComplexityType
     */
    public function complexityType()
    {
        return $this->hasOne('ComplexityType', 'id', 'complexity_id');
    }

    /**
     * @return WorkloadType
     */
    public function workloadType()
    {
        return $this->hasOne('WorkloadType', 'id', 'workload_id');
    }
}
