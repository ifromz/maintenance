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

    /**
     * Execute the command
     */
    public function fire()
    {
        $this->call('migrate', ['--env' => $this->option('env'), '--package' => 'stevebauman/maintenance']);
    }

}