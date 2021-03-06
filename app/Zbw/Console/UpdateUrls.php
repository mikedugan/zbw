<?php namespace Zbw\Console;

use Illuminate\Console\Command;
use Zbw\Bostonjohn\Datafeed\Vatsim;

/**
 * @package Zbw\Commands
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class UpdateUrls extends Command
{

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
     *
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
        \Datafeed::where('expires', '<', \Carbon::now()->subDay(1))->delete();
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
