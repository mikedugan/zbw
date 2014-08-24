<?php

require_once public_path() . '/forum/smf_2_api.php';

App::register('Zbw\Users\UsersServiceProvider');
App::register('Zbw\Training\TrainingServiceProvider');
App::register('Zbw\Cms\CmsServiceProvider');
App::register('Zbw\Poker\PokerServiceProvider');

App::bind(
  'Laracasts\Commander\CommandTranslator',
  'Zbw\Base\CommandTranslator'
);

Bugsnag::setAppVersion(\Config::get('zbw.version'));
Bugsnag::setBeforeNotifyFunction('beforeBugsnagNotify');

function beforeBugsnagNotify($error)
{
    /*if(Sentry::check())
        $user = \Sentry::getUser();
        $error->setMetaData([
              'user' => [
                  'name' => $user->initials,
                  'email' => $user->email
              ]
        ]);*/
}

//custom validation rules that need a new home

Validator::extend('cid', function($attribute, $value, $parameters)
{
    return $value === 100 || ($value > 500000 && $value < 3000000);
});
