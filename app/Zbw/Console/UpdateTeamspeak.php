<?php  namespace Zbw\Console;

use Illuminate\Console\Command;
use Zbw\Teamspeak\Teamspeak;

class UpdateTeamspeak extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vatsim:ts3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates ZBW Teamspeak clients.';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $teamspeak = new Teamspeak();
    }
} 
