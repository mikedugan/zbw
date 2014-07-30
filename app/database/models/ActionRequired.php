<?php

use \Zbw\Base\Helpers as Helpers;

/**
 * ActionRequired
 *
 * @property integer $id
 * @property boolean $resolved
 * @property integer $resolved_by
 * @property string $url
 * @property integer $cid
 * @property string $title
 * @property string $description
 * @method static \Illuminate\Database\Query\Builder|\ActionRequired whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\ActionRequired whereResolved($value) 
 * @method static \Illuminate\Database\Query\Builder|\ActionRequired whereResolvedBy($value) 
 * @method static \Illuminate\Database\Query\Builder|\ActionRequired whereUrl($value) 
 * @method static \Illuminate\Database\Query\Builder|\ActionRequired whereCid($value) 
 * @method static \Illuminate\Database\Query\Builder|\ActionRequired whereTitle($value) 
 * @method static \Illuminate\Database\Query\Builder|\ActionRequired whereDescription($value) 
 */
class ActionRequired extends BaseModel
{
	protected $table = 'zbw_actionsrequired';
	protected $guarded = [];
    public $timestamps = false;
    public $rules = [
        'resolved_by' => '',
        'url' => 'url',
        'cid' => ''
    ];

    public function __construct()
    {
        $cids = Helpers::getCids(true);
        $this->rules['resolved_by'] = 'in:' . $cids;
        $this->rules['cid'] = 'in:' . $cids;
    }
}
