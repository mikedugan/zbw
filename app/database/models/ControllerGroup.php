<?php

class ControllerGroup extends Eloquent {
	protected $guarded = ['name'];
	protected $table = 'controller_groups';
	public static $rules = array();
}
