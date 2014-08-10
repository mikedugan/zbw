<?php namespace Zbw\Commands;

use Illuminate\Console\Command;

/**
 *
 */
class UpdateClients extends Command
{

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
        \ZbwFlight::truncate();
        $df = new \Zbw\Bostonjohn\Datafeed\DatafeedParser();
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
