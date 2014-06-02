<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Zbw\Bostonjohn\Vatsim;

class UpdateUrls extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vatsim:urls';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Updates the VATSIM server URLs.';

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
		$vatsim = new Vatsim();
    $vatsim->updateStatus();
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
