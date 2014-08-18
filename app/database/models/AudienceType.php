<?php

/**
 * AudienceType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\AudienceType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\AudienceType whereValue($value)
 */
class AudienceType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_audience_types';
    public $timestamps = false;

    static $rules = [
        'value' => 'required'
    ];
}
