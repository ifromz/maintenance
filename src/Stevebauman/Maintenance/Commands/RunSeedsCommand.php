<?php

namespace Stevebauman\Maintenance\Commands;

use Illuminate\Console\Command;

class RunSeedsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:run-seeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs seeds for the maintenance application';

    public function fire()
    {
        $this->seedUserTableFromLdap();

        $this->seedPrioritiesTable();

        $this->seedStatusesTable();

        $this->seedMetricsTable();
    }

    private function seedUserTableFromLdap()
    {
        $message = 'Do you want to seed the maintenance user table with active directory?'
            .' This requires that you have ldap fully enabled and configured. [yes|no]';

        if ($this->confirm($message)) {
            $this->call('db:seed', ['--class' => 'Stevebauman\Maintenance\Seeders\LdapUserSeeder']);

            $this->info('Successfully seeded database with LDAP users');
        }
    }

    private function seedPrioritiesTable()
    {
        $message = 'Do you want to seed the maintenance work order priorities table?'
            .' You can customize the default data in the Seed config file. [yes|no]';

        if ($this->confirm($message)) {
            $this->call('db:seed', ['--class' => 'Stevebauman\Maintenance\Seeders\PrioritySeeder']);

            $this->info('Successfully seeded database with config priorities');
        }
    }

    private function seedStatusesTable()
    {
        $message = 'Do you want to seed the maintenance work order statuses table?'
            .' You can customize the default data in the Seed config file. [yes|no]';

        if ($this->confirm($message)) {
            $this->call('db:seed', ['--class' => 'Stevebauman\Maintenance\Seeders\StatusSeeder']);

            $this->info('Successfully seeded database with config statuses');
        }
    }

    private function seedMetricsTable()
    {
        $message = 'Do you want to seed the maintenance metrics table?'
            .' You can customize the default data in the Seed config file. [yes|no]';

        if ($this->confirm($message)) {
            $this->call('db:seed', ['--class' => 'Stevebauman\Maintenance\Seeders\MetricSeeder']);

            $this->info('Successfully seeded database with config metrics');
        }
    }
}
