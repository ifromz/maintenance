<?php

namespace Stevebauman\Maintenance\Tests;

use Stevebauman\Maintenance\MaintenanceServiceProvider;
use Orchestra\Testbench\TestCase;

class FunctionalTestCase extends TestCase
{
    /**
     * Setup the testing environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/Migrations'),
        ]);
    }

    /**
     * Returns the package service providers.
     *
     * @return array
     */
    protected function getPackageProviders()
    {
        return [
            MaintenanceServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $application
     */
    protected function getEnvironmentSetup($application)
    {
        $application['config']->set('database.default', 'testbench');
        $application['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
