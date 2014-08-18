<?php

/**
 * WorkloadType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\WorkloadType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\WorkloadType whereValue($value)
 */
class WorkloadType extends BaseModel {
    protected $fillable = ['type'];
	protected $table = '_workload_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
}
