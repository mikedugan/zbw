<?php 

/**
 * MessageType
 *
 * @property integer $id
 * @property string $value
 * @method static \Illuminate\Database\Query\Builder|\MessageType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\MessageType whereValue($value)
 */
class MessageType extends BaseModel
{
    protected $fillable = ['value'];
    protected $table = '_message_types';
    public $timestamps = false;
    static $rules = [
        'value' => 'required'
    ];
} 
