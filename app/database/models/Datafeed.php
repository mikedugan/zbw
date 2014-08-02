<?php

/**
 * Datafeed
 *
 * @property string $key
 * @property string $value
 * @property string $expires
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Datafeed whereKey($value) 
 * @method static \Illuminate\Database\Query\Builder|\Datafeed whereValue($value) 
 * @method static \Illuminate\Database\Query\Builder|\Datafeed whereExpires($value) 
 * @method static \Illuminate\Database\Query\Builder|\Datafeed whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Datafeed whereUpdatedAt($value) 
 */
class Datafeed extends BaseModel
{
    protected $guarded = [];
    protected $table = '_datafeeds';
    static $rules = [
        'key' => 'required',
        'value' => 'required',
        'expires' => 'date'
    ];
}
