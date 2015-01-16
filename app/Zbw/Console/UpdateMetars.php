<?php namespace Zbw\Console;

use Illuminate\Console\Command;
use Zbw\Bostonjohn\Datafeed\EloquentMetarRepository;
use Zbw\Bostonjohn\Datafeed\MetarFactory;

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

    protected $metars;

    protected $metarFactory;

    /**
     * Create a new command instance.
     *
     * @return UpdateMetars
     */
    public function __construct(EloquentMetarRepository $metars = null, MetarFactory $metarFactory = null)
    {
        parent::__construct();
        $this->metars = is_null($metars) ? new EloquentMetarRepository() : $metars;
        $this->metarFactory = is_null($metarFactory) ? new MetarFactory() : $metarFactory;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->metarFactory->updateMetars();
        \Cache::tags('metars')->flush();
        $this->info('METARs updated successfully!');
        $metars = $this->metars->getStaleMetars();
        if(! empty($metars)) {
            $this->metars->delete($this->metars->getStaleMetars());
        }
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
