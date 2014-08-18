<?php

/**
 * TrainingFacility
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\TrainingFacility whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingFacility whereValue($value)
 */
class TrainingFacility extends BaseModel
{
    protected $table = "_training_facilities";
    public $timestamps = false;
    protected $guarded = [];
    static $rules = [
      'value' => 'required'
    ];
}
