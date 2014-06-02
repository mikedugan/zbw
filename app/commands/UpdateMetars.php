<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Zbw\Bostonjohn\MetarCreator;

class UpdateMetars extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vatsim:metars';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update the METARs from the VATSIM server';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
    $metar = new MetarCreator();
    $metar->updateMetars();
    $this->info('METARs updated successfully!');
    $deletes = \Metar::where('created_at', '<', Carbon::now()->subMinutes(2))->lists('id');
    \Metar::destroy($deletes);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(

		);
	}

}
