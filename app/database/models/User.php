<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;


class User extends SentryUser implements UserInterface, RemindableInterface
{

    protected $guarded = ['cid', 'email', 'rating', 'is_webmaster', 'is_staff'];
    protected $primaryKey = 'cid';
    protected $positions;
    protected static $hasher;
    public function __construct()
    {
        static::$hasher = new Cartalyst\Sentry\Hashing\NativeHasher();
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
        return $this->hasMany('TrainingSession', 'cid', 'cid');
    }

    public function exams()
    {
        return $this->hasMany('Exam', 'cid', 'cid');
    }

    public function certification()
    {
        return $this->hasOne('CertType', 'id', 'cert');
    }

    public function subscriptions()
    {
        return $this->hasMany('Subscription', 'cid', 'cid');
    }

    public function rating()
    {
        return $this->hasOne('Rating', 'id', 'rating_id');
    }


    //auth related
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
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
