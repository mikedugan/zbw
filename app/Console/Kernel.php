<?php namespace Zbw\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'Zbw\Console\Commands\Inspire',
		'Zbw\Console\Commands\UpdateMetars',
		'Zbw\Console\Commands\UpdateUrls',
		'Zbw\Console\Commands\UpdateClients',
		'Zbw\Console\Commands\UpdateRoster',
		'Zbw\Console\Commands\MigrateOldRoster',
		'Zbw\Console\Commands\ImportExamQuestions',
		'Zbw\Console\Commands\UpdateTeamspeak'
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')
				 ->hourly();
	}

}
