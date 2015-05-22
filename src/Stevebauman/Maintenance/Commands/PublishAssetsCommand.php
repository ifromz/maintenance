<?php

namespace Stevebauman\Maintenance\Commands;

use Illuminate\Console\Command;

/**
 * Publishes all of the maintenance assets
 * and configuration files for modification.
 *
 * Class PublishAssetsCommand
 */
class PublishAssetsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes the maintenance assets and configuration files';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Publishing Maintenance Assets (This could take a while)');

        $this->call('asset:publish', [
            'package' => 'stevebauman/maintenance',
        ]);

        $this->info('Publishing Configuration Files');

        $command = 'config:publish';

        $this->call($command, [
            'package' => 'stevebauman/corp',
        ]);

        $this->call($command, [
            'package' => 'stevebauman/eloquenttable',
        ]);

        $this->call($command, [
            'package' => 'stevebauman/inventory',
        ]);

        $this->call($command, [
            'package' => 'stevebauman/calendar-helper',
        ]);

        $this->call($command, [
            'package' => 'stevebauman/calendar-helper',
        ]);

        $this->call($command, [
            'package' => 'arcanedev/no-captcha',
        ]);
    }
}
