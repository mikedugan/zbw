<?php  namespace Zbw\Console;

use Illuminate\Console\Command;

/**
 * @package Zbw\Commands
 * @author  Mike Dugan <mike@mjdugan.com>
 * @since   2.0.1b
 */
class UpdateRoster extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vatsim:roster';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates ARTCC roster from VATUSA.';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $parser = \App::make('Zbw\Bostonjohn\Roster\VatusaRosterUpdater');
        if(($new_members = $parser->update())) {
            $this->info('Roster updated with '.$new_members.' new members');
        }
    }
} 
