<?php namespace Zbw\Commands;

use Illuminate\Console\Command;
use Zbw\Bostonjohn\Datafeed\MetarCreator;

/**
 * @package Zbw\Commands
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class UpdateMetars extends Command
{

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
     * @return UpdateMetars
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
        /*$deletes = \Metar::where(
          'created_at', '<', \Carbon::now()->subMinutes(2)
        )->lists('id');
        \Metar::destroy($deletes);*/
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }

}
