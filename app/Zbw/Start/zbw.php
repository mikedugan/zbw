<?php

require_once public_path() . '/forum/smf_2_api.php';

App::register('Zbw\Users\UsersServiceProvider');
App::register('Zbw\Training\TrainingServiceProvider');
App::register('Zbw\Cms\CmsServiceProvider');
App::register('Zbw\Poker\PokerServiceProvider');

//custom validation rules that need a new home

Validator::extend('cid', function($attribute, $value, $parameters)
{
    return $value === 100 || ($value > 500000 && $value < 3000000);
});
