<?php

use \Zbw\Helpers as Helpers;

class ActionRequired extends Eloquent
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
