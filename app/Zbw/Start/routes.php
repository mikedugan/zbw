<?php

if(\App::environment() === 'local') {
    Event::listen('illuminate.query', function ($query) {
        \Log::debug('query: ' . $query);
    });
}

Route::when('staff/*', 'staff');
require_once 'staff_routes.php';
require_once 'member_routes.php';
require_once 'public_routes.php';
