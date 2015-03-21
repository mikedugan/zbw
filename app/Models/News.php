<?php

/**
 * News
 *
 * @property integer $id
 * @property boolean $news_type_id
 * @property boolean $audience_type_id
 * @property string $title
 * @property string $content
 * @property \Carbon\Carbon $starts
 * @property \Carbon\Carbon $ends
 * @property boolean $facility_id
 * @property string $deleted_at
 * @property string $created_at
 * @property string $updated_at
 * @property-read \NewsType $newsType
 * @property-read \Facility $facility
 * @method static \Illuminate\Database\Query\Builder|\News whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereNewsTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereAudienceTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereStarts($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereEnds($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereFacilityId($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\News whereUpdatedAt($value)
 * @method static \News events()
 * @method static \News news()
 * @method static \News policies()
 * @method static \News forum()
 * @method static \News staff()
 * @method static \News endsBefore($date)
 * @method static \News endsAfter($date)
 * @method static \News startsBefore($date)
 * @method static \News startsAfter($date)
 */
class News extends BaseModel
{
    protected $guarded = ['audience', 'deleted_at'];
    protected $table = 'zbw_news';
    static $rules = [
        'news_type_id' => 'required|integer|between:0,6',
        'audience_type_id' => 'required|integer|between:0,6',
        'title' => 'required',
        'content' => 'required',
        'start' => 'date',
        'ends' => 'date',
        'facility_id' => 'integer|between:0,50'
    ];

    public function getDates()
    {
        return ['starts', 'ends', 'created_at', 'updated_at'];
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
