<?php

\Route::when('staff/*', 'staff');
require_once 'staff_routes.php';
require_once 'member_routes.php';
require_once 'public_routes.php';
