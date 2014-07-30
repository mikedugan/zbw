<?php

/**
 * ComplexityType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\ComplexityType whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\ComplexityType whereValue($value) 
 */
class ComplexityType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_complexity_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
}
