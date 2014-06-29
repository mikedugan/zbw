<?php

$me = Auth::user();
View::share('me', $me);
if ($me)
    View::share('messages', Zbw\Cms\MessagesRepository::newMessageCount($me->cid));
Route::when('staff/*', 'staff');

require_once 'public_routes.php';
require_once 'member_routes.php';
require_once 'staff_routes.php';
