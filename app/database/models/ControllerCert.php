<?php

class ControllerCert extends Eloquent {
	protected $guarded = ['cid', 'passed'];
	protected $table = 'controller_certs';
	public static $rules = array();
}
