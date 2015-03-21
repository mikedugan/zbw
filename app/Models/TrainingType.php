<?php

/**
 * TrainingType
 *
 * @property integer $id
 * @property string $value
 * @property string $display
 * @method static \Illuminate\Database\Query\Builder|\TrainingType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingType whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\TrainingType whereDisplay($value)
 */
class TrainingType extends BaseModel
{
    protected $fillable = ['type'];
    protected $table = '_training_types';
    public $timestamps = false;
    static $rules = [
      'value' => 'required'
    ];
}
