<?php namespace Zbw\Console\Commands;

use Illuminate\Console\Command;
use Zbw\Training\ExamImporter;

class ImportExamQuestions extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vatsim:questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the exam questions from csv';

    /**
     * Create a new command instance.
     *
     * @return ImportExamQuestions
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
        $importer = new ExamImporter();
        $total = $importer->import();
        $this->info($total . ' questions were added');
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
