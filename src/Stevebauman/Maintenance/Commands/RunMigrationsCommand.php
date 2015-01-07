<?php

namespace Stevebauman\Maintenance\Commands;

use Illuminate\Console\Command;

class RunMigrationsCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:run-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the maintenance application migrations';

    public function fire()
    {
        $this->call('migrate', array('--env' => $this->option('env'), '--bench' => 'stevebauman/maintenance' ) );
    }

}