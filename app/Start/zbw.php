<?php

if(! function_exists('beforeBugsnagNotify')) {
	function beforeBugsnagNotify($error)
	{
	    if(\Sentry::check()) {
	        $user = \Sentry::getUser();
	        $error->setMetaData([
	            'user' => [
	                'name'  => $user->username,
	                'email' => $user->email
	            ]
	        ]);
	    }
	}
}
