<?php 

/**
 * FileType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\FileType whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\FileType whereValue($value) 
 */
class FileType extends BaseModel
{
    protected $table = '_file_types';
    protected $fillable = ['type'];
    public $timestamps = false;
} 
