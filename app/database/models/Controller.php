<?php

class Controller extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

	protected $positions;
	public function __construct()
	{
		$this->positions = ['is_mentor', 'is_instructor', 'is_facilities', 'is_webmaster', 'is_atm', 'is_datm', 'is_ta'];
	}

	//scopes

	public function scopeMentors($query)
	{
		return $query->where('is_mentor', '=', 1);
	}

	public function scopeInstructors($query)
	{
		return $query->where('is_instructor', '=', 1);
	}

	public function scopeStaff($query)
	{
		return $query->where('is_atm', '=', 1)
					->orWhere('is_datm', '=', 1)
					->orWhere('is_ta', '=', 1)
					->orWhere('is_mentor', '=', 1)
					->orWhere('is_instructor', '=', 1)
					->orWhere('is_facilities', '=', 1)
					->orWhere('is_webmaster', '=', 1);
	}

	public function scopeExecutive($query)
	{
		return $query->where('is_atm', '=', 1)
						->orWhere('is_datm', '=', 1)
						->orWhere('is_ta', '=', 1);
	}

	//relations
	public function group()
	{
		return $this->hasMany('ControllerGroup');
	}

	public function training()
	{
		return $this->hasMany('ControllerTraining');
	}

	public function exams()
	{
		return $this->hasMany('ControllerExam');
	}

}
