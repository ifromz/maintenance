<?php

namespace Stevebauman\Maintenance\Tests;

use Stevebauman\Maintenance\MaintenanceServiceProvider;
use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase;

class FunctionalTestCase extends TestCase
{
    /**
     * Setup the testing environment.
     */
    public function setUp()
    {
        parent::setUp();

        // Share view errors to prevent undefined variable in views
        View::share('errors', Session::get('errors', new \Illuminate\Support\MessageBag));

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--path'     => '../vendor/cartalyst/sentry/src/migrations',
        ]);

        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--path' => __DIR__.'/Migrations',
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

    protected function setUserIsAdmin()
    {
        $group = $this->createSentryGroup('admins', ['superuser' => 1]);

        $user = $this->createSentryUser('Admin', 'admin@email.com', true, [$group]);

        return Sentry::setUser($user);
    }

    protected function setUserIsWorker()
    {

    }

    /**
     * Creates a user through Sentry.
     *
     * @param string    $name
     * @param string    $email
     * @param bool|true $activated
     * @param array     $groups
     *
     * @return \Stevebauman\Maintenance\Models\User
     */
    private function createSentryUser($name, $email, $activated = true, array $groups = [])
    {
        $insert = [
            'first_name' => $name,
            'email' => $email,
            'password' => str_random(10),
            'activated' => $activated,
        ];

        $user = Sentry::createUser($insert);

        foreach($groups as $group) {
            $user->addGroup($group);
        }

        return $user;
    }

    /**
     * Creates a group through Sentry.
     *
     * @param string $name
     * @param array  $permissions
     *
     * @return \Stevebauman\Maintenance\Models\Group
     */
    private function createSentryGroup($name, array $permissions = [])
    {
        $insert = [
            'name' => $name,
            'permissions' => $permissions,
        ];

        return Sentry::createGroup($insert);
    }
}
