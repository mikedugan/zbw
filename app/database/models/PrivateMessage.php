<?php

class PrivateMessage extends Eloquent {
	protected $guarded = array();
	protected $table = 'zbw_messages';
	public static $rules = array();
}
