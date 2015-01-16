<?php

namespace Stevebauman\Maintenance\Commands;

use Illuminate\Support\Facades\Schema;
use Stevebauman\Maintenance\Exceptions\Commands\DatabaseTableReservedException;
use Stevebauman\Maintenance\Exceptions\Commands\DependencyNotFoundException;
use Illuminate\Console\Command;

class SchemaCheckCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:check-schema';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the current database to make sure the required tables are present, and the reserved tables are not';

    /*
     * Holds the database tables that must be present before install
     */
    protected $dependencies = array(
        'users'         => 'sentry',
        'users_groups'  => 'sentry',
        'groups'        => 'sentry',
        'throttle'      => 'sentry',
        'revisions'     => 'revisionable',
        'inventories' => 'inventory',
        'inventory_stocks' => 'inventory',
        'inventory_stock_movements' => 'inventory',
        'locations' => 'inventory',
        'categories' => 'inventory',
        'metrics' => 'inventory',
    );

    protected $supplierCommands = array(
        'sentry' => array(
            'type' => 'migrate',
            'args' => array('--package' => 'cartalyst/sentry')
        ),
        'revisionable' => array(
            'type' => 'migrate',
            'args' => array('--package' => 'venturecraft/revisionable')
        ),
        'inventory' => array(
            'type' => 'migrate',
            'args' => array('--package' => 'stevebauman/inventory')
        ),
    );

    /*
     * Holds the required database tables necessary to install
     */
    protected $reserved = array(
        'assets',
        'asset_images',
        'asset_manuals',
        'asset_meters',
        'attachments',
        'eventables',
        'events',
        'event_reports',
        'meters',
        'meter_readings',
        'notifications',
        'priorities',
        'statuses',
        'updates',
        'work_orders',
        'work_order_assets',
        'work_order_assignments',
        'work_order_attachments',
        'work_order_customer_updates',
        'work_order_technician_updates',
        'work_order_notifications',
        'work_order_parts',
        'work_order_reports',
        'work_order_sessions',
    );

    /**
     * Executes the console command
     *
     * @throws DatabaseTableReservedException
     * @throws DependencyNotFoundException
     */
    public function fire()
    {
        if($this->checkDependencies()) {
            $this->info('Schema dependencies are all good!');
        }

        if($this->checkReserved()) {
            $this->info('Schema reserved tables are all good!');
        }
    }

    /**
     * Checks the current database for dependencies
     *
     * @return bool
     * @throws DependencyNotFoundException
     */
    private function checkDependencies()
    {
        foreach($this->dependencies as $table => $suppliedBy) {

            if(!$this->tableExists($table)) {

                if (!$this->confirmInstallDependency($suppliedBy)) {

                    $message = sprintf('Table: %s does not exist, it is supplied by the package %s', $table, $suppliedBy);

                    throw new DependencyNotFoundException($message);

                }

            }

        }

        return true;
    }

    /**
     * Checks the current database for reserved tables
     *
     * @return bool
     * @throws DatabaseTableReservedException
     */
    private function checkReserved()
    {
        foreach($this->reserved as $table) {

            if($this->tableExists($table)) {

                $message = sprintf('Table: %s already exists. This table is reserved. Please remove the database table to continue', $table);

                throw new DatabaseTableReservedException($message);

            }

        }

        return true;
    }

    /**
     * Runs the commands for a dependency that has not yet been installed
     *
     * @param string $dependency
     * @return boolean
     */
    private function confirmInstallDependency($dependency)
    {
        $message = sprintf('It looks like the dependency: %s has not been migrated but it has been installed. Do you want me to migrate it for you? [yes|no]', ucfirst($dependency));

        if($this->confirm($message)) {

            /*
             * Add environment option to the dependencies command if it's a migration
             */
            if($this->supplierCommands[$dependency]['type'] === 'migrate') {
                $this->supplierCommands[$dependency]['args']['--env'] = $this->option('env');
            }

            $this->call($this->supplierCommands[$dependency]['type'], $this->supplierCommands[$dependency]['args']);

            return true;

        } else {

            return false;

        }
    }

    /**
     * @param string $table
     * @return boolean
     */
    private function tableExists($table)
    {
        return Schema::hasTable($table);
    }
}