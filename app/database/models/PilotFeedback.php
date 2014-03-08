<?php

class PilotFeedback extends Eloquent {
	protected $guarded = ['ip', 'email'];
	protected $table = 'pilot_feedback';
	public static $rules = array();
}
