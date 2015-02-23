<?php

namespace Stevebauman\Maintenance\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data into the maintenance application';

    /**
     * The available import sources
     *
     * @var array
     */
    protected $sources = array(
        'dynamics'
    );

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->call('maintenance:import-dynamics', array('component' => $this->argument('component')));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('source', InputArgument::REQUIRED, 'The source to import (ex. Dynamics)'),
            array('component', InputArgument::REQUIRED, 'The maintenance component (ex. assets)'),
        );
    }
}