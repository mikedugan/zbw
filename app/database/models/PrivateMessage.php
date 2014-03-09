<?php

class PrivateMessage extends Eloquent {
	protected $guarded = array();
	protected $table = 'zbw_messages';
	public static $rules = [
        'from' => '',
        'to' => '',
        'subject' => 'max:60'
    ];

    public function __construct()
    {
        $cids = \Zbw\Helpers::getCids(true);
        $this->rules['from'] = 'in:' . $cids;
        $this->rules['to'] = 'in:' . $cids;
    }
}
