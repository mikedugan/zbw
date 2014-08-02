<?php 

/**
 * Facility
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\Facility whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Facility whereValue($value) 
 */
class Facility extends BaseModel {
    public $timestamps = false;
    protected $table = '_facilities';
    protected $fillable = ['value'];
    static $rules = [
        'value' => 'required'
    ];
} 
