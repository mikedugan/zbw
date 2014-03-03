<?php

class News extends Eloquent {
	protected $guarded = array();
	protected $table = 'zbw_news';
	public static $rules = array();

	//scopes
	public function scopeEvents($query)
	{
		return $query->where('type', '=', 'event');
	}

	public function scopeNews($query)
	{
		return $query->where('type', '=', 'news');
	}

	public function scopePolicies($query)
	{
		return $query->where('type', '=', 'policy');
	}

	public function scopeForum($query)
	{
		return $query->where('type', '=', 'forum');
	}

	public function scopeStaff($query)
	{
		return $query->where('type', '=', 'staff');
	}

	public function scopeControllers($query)
	{
		return $query->where('audience', '=', 'controllers');
	}

	public function scopePilots($query)
	{
		return $query->where('audience', '=', 'pilots');
	}

	public function scopeAll($query)
	{
		return $query->where('audience', '=', 'both')->where('type', '!=', 'staff');
	}

	//relations
}
