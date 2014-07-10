<?php namespace Zbw\Commands;

use Illuminate\Console\Command;
use Zbw\Bostonjohn\Vatsim;

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
