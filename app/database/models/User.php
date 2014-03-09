<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	protected $table = 'controllers';
	protected $guarded = ['cid', 'email', 'rating', 'is_webmaster', 'is_staff'];
	protected $primaryKey = 'cid';
	protected $positions;
    public $rules = [
        'username' => 'alpha',
        'cid' => 'integer',
        'initials' => 'alpha|max:2',
        'first_name' => 'alpha|max:30',
        'last_name' => 'alpha|max:30',
        'email' => 'email|max:60',
        'rating' => 'alpha_num|max:3',
        'artcc' => 'alpha|max:3'
    ];

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

	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
