<?php 

/**
 * Template
 *
 * @property integer $id
 * @property string $title
 * @method static \Illuminate\Database\Query\Builder|\Template whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Template whereTitle($value)
 */
class Template extends BaseModel
{
    protected $guarded = [''];
    protected $table = 'zbw_templates';
} 
