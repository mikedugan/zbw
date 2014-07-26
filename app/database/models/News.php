<?php

class News extends BaseModel
{
    protected $guarded = ['audience', 'deleted_at'];
    protected $table = 'zbw_news';

    public static function boot()
    {
        parent::boot();

        static::saving(function($model) {
              return false;
          });
    }

    public function getDates()
    {
        return ['starts', 'ends'];
    }
    //scopes
    /**
     * @param Query $query
     *
     * @return Eloquent
     */
    public function scopeEvents($query)
    {
        return $query->where('type', '=', 'event');
    }

    /**
     * @param Query $query
     *
     * @return Eloquent
     */
    public function scopeNews($query)
    {
        return $query->where('type', '=', 'news');
    }

    /**
     * @param Query $query
     *
     * @return Eloquent
     */
    public function scopePolicies($query)
    {
        return $query->where('type', '=', 'policy');
    }

    /**
     * @param Query $query
     *
     * @return Eloquent
     */
    public function scopeForum($query)
    {
        return $query->where('type', '=', 'forum');
    }

    /**
     * @param Query $query
     *
     * @return Eloquent
     */
    public function scopeStaff($query)
    {
        return $query->where('type', '=', 'staff');
    }

    /**
     * @param Query $query
     *
     * @return Eloquent
     */
    /*   public function scopeFacility($query, $fac)
       {
           return $query->where('facility', '=', $fac);
       }*/

    /**
     * @param Query  $query
     * @param Carbon $date
     *
     * @return Eloquent
     */
    public function scopeEndsBefore($query, $date)
    {
        return $query->where('ends', '<', $date);
    }

    /**
     * @param Query  $query
     * @param Carbon $date
     *
     * @return Eloquent
     */
    public function scopeEndsAfter($query, $date)
    {
        return $query->where('ends', '>', $date);
    }

    /**
     * @param Query  $query
     * @param Carbon $date
     *
     * @return Eloquent
     */
    public function scopeStartsBefore($query, $date)
    {
        return $query->where('starts', '<', $date);
    }

    /**
     * @param Query   $query
     * @param \Carbon $date
     *
     * @return Eloquent
     */
    public function scopeStartsAfter($query, \Carbon\Carbon $date)
    {
        return $query->where('starts', '>', $date);
    }

    //relations

    public function newsType()
    {
        return $this->hasOne('NewsType', 'id', 'news_type_id');
    }

    public function facility()
    {
        return $this->hasOne('Facility', 'id', 'facility_id');
    }
}
