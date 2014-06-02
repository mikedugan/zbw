<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateClients extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'vatsim:clients';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Updates VATSIM ATC and pilot clients.';

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
      \ZbwFlight::truncate();
		  $df = new \Zbw\Bostonjohn\DatafeedParser();
      $df->parseDatafeed();
      $this->info('Clients list updated successfully');
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
