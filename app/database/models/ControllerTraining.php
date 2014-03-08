<?php

class ControllerTraining extends Eloquent {
	protected $guarded = ['cid', 'sid'];
	protected $table = 'controller_training';
	public static $rules = [

	];
}
