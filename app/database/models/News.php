<?php

class News extends Eloquent {
	protected $guarded = ['audience', 'deleted_at'];
	protected $table = 'zbw_news';
    public $rules = [
        'news_type' => 'integer|max:4',
        'audience' => 'integer|max:4',
        'title' => 'max:60',
        'starts' => 'date',
        'ends' => 'date',
    ];
	//scopes
    /**
     * @param Query $query
     * @return Eloquent
     */
    public function scopeEvents($query)
	{
		return $query->where('type', '=', 'event');
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
	public function scopeNews($query)
	{
		return $query->where('type', '=', 'news');
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
	public function scopePolicies($query)
	{
		return $query->where('type', '=', 'policy');
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
	public function scopeForum($query)
	{
		return $query->where('type', '=', 'forum');
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
	public function scopeStaff($query)
	{
		return $query->where('type', '=', 'staff');
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
	public function scopeControllers($query)
	{
		return $query->where('audience', '=', 'controllers')->where('news_type', '!=', 'staff')->get();
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
	public function scopePilots($query)
	{
		return $query->where('audience', '=', 'pilots')->where('news_type', '!=', 4)->get();
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
	public function scopeFront($query, $lim)
	{
		return $query->where('audience', '=', 'both')->where('news_type', '!=', '4')->limit($lim)->get();
	}

    /**
     * @param Query $query
     * @return Eloquent
     */
    public function scopeFacility($query, $fac)
    {
        return $query->where('facility', '=', $fac);
    }

    /**
     * @param Query $query
     * @param Carbon $date
     * @return Eloquent
     */
    public function scopeEndsBefore($query, $date)
    {
        return $query->where('ends', '<', $date);
    }

    /**
     * @param Query $query
     * @param Carbon $date
     * @return Eloquent
     */
    public function scopeEndsAfter($query, $date)
    {
        return $query->where('ends', '>', $date);
    }

    /**
     * @param Query $query
     * @param Carbon $date
     * @return Eloquent
     */
    public function scopeStartsBefore($query, $date)
    {
        return $query->where('starts', '<', $date);
    }

    /**
     * @param Query $query
     * @param Carbon $date
     * @return Eloquent
     */
    public function scopeStartsAfter($query, \Carbon\Carbon $date)
    {
        return $query->where('starts', '>', $date);
    }

	//relations

    public function type()
    {
        return $this->hasOne('NewsType', 'id', 'news_type');
    }
}
