<?php  namespace Zbw\Commands;

use Illuminate\Console\Command;

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
        $parser = \App::make('Zbw\Bostonjohn\Roster\RosterXmlParser');
        if(($new_members = $parser->updateRoster())) {
            $this->info('Roster updated with '.$new_members.' new members');
        }
    }
} 
