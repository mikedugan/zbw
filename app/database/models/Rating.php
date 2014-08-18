<?php

/**
 * Rating
 *
 * @property integer $id
 * @property string $short
 * @property string $medium
 * @property string $long
 * @property string $grp
 * @method static \Illuminate\Database\Query\Builder|\Rating whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Rating whereShort($value)
 * @method static \Illuminate\Database\Query\Builder|\Rating whereMedium($value)
 * @method static \Illuminate\Database\Query\Builder|\Rating whereLong($value)
 * @method static \Illuminate\Database\Query\Builder|\Rating whereGrp($value)
 */
class Rating extends \Eloquent
{
    protected $guarded = [];
    protected $table = '_ratings';
    public $timestamps = false;
    static $rules = [
        'short' => 'max:3',
        'medium' => 'max:20',
        'long' => 'max:30',
        'grp' => 'max:30'
    ];
}
