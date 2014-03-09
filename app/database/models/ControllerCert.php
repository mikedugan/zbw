<?php

class ControllerCert extends Eloquent {
	protected $guarded = ['cid', 'passed'];
	protected $table = 'controller_certs';
	public static $rules = [
        'cid' => '',
        'exam_id' => 'between:1,10',
        'times_taken' => 'integer',
        'first_exam' => 'date',
        'last_exam' => 'date',
        'first_request' => 'date',
        'last_request' => 'date'
    ];
    public function __construct()
    {
        $cids = \Zbw\Helpers::getCids(true);
        $this->rules['cid'] = 'in:' . $cids;
    }
}
