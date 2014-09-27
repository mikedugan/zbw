<?php

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/

Artisan::add(new Zbw\Console\UpdateMetars);
Artisan::add(new Zbw\Console\UpdateUrls);
Artisan::add(new Zbw\Console\UpdateClients);
Artisan::add(new Zbw\Console\UpdateRoster);
Artisan::add(new Zbw\Console\MigrateOldRoster);
Artisan::add(new Zbw\Console\ImportExamQuestions);
Artisan::add(new Zbw\Console\UpdateTeamspeak);
