<?php
if(\Sentry::check()) {
    $me = \Sentry::getUser();
    \View::share('me', $me);
    \View::share('messages', Zbw\Cms\MessagesRepository::newMessageCount($me->cid));
}
Route::when('staff/*', 'staff');
require_once 'public_routes.php';
require_once 'member_routes.php';
require_once 'staff_routes.php';
