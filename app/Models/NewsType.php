<?php

/**
 * NewsType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\NewsType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NewsType whereValue($value)
 */
class NewsType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_news_types';
    public $timestamps = false;
    static $rules = [
      'value' => 'required'
    ];
}
