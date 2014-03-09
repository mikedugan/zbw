<?php

class PrivateMessage extends Eloquent {
	protected $guarded = array();
	protected $table = 'zbw_messages';
	public $rules;
    public function __construct()
    {
        $cids = \Zbw\Helpers::getCids(true);
        $this->rules = [
            'from' => 'in:' . $cids,
            'to' => 'in:' . $cids,
            'subject' => 'max:60'
        ];

    }
}
