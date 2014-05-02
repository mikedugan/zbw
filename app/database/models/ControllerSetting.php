<?php

class ControllerSetting extends Eloquent {
    protected $guarded = ['cid'];
	protected $table = 'zbw_controller_settings';
    public $timestamps = false;
    /**
     * available settings
     *	email_is_hidden (bool)
     * 	receive_email_notifications (bool)
     */
}
