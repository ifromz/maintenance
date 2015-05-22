<?php

namespace Stevebauman\Maintenance;

use Stevebauman\Maintenance\Services\SentryService;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class MaintenanceServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The configuration separator for packages.
     * Allows compatibility with Laravel 4 and 5.
     *
     * @var string
     */
    public static $configSeparator = '::';

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if (method_exists($this, 'package')) {
            /*
             * Looks like we're using Laravel 4, let's use the
             * package method to easily register everything
             */
            $this->package('stevebauman/maintenance');
        } else {
            /*
             * Looks like we're using Laravel 5, let's set
             * our configuration file to be publishable
             */
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('maintenance.php'),
            ], 'config');

            /*
             * Assign the migrations as publishable, and tag it as 'migrations'
             */
            $this->publishes([
                __DIR__.'../../../migrations/' => base_path('database/migrations'),
            ], 'migrations');

            /*
             * Allow the views to be publishable
             */
            $this->publishes([
                __DIR__.'/../../views' => base_path('resources/views/stevebauman/maintenance'),
            ], 'views');

            /*
             * Load our views
             */
            $this->loadViewsFrom(__DIR__.'/../../views', 'maintenance');

            $this::$configSeparator = '.';
        }

        $this->bootCommands();

        $this->bootRequiredFiles();
    }

    /**
     * Registers all the maintenance commands.
     */
    private function bootCommands()
    {
        $this->app->bind('maintenance:install', function () {
            return new Commands\InstallCommand();
        });

        $this->app->bind('maintenance:run-migrations', function () {
            return new Commands\RunMigrationsCommand();
        });

        $this->app->bind('maintenance:run-seeds', function () {
            return new Commands\RunSeedsCommand();
        });

        $this->app->bind('maintenance:check-depends', function () {
            return new Commands\DependencyCheckCommand();
        });

        $this->app->bind('maintenance:check-schema', function () {
            return new Commands\SchemaCheckCommand();
        });

        $this->app->bind('maintenance:create-admin', function () {
            return new Commands\CreateAdminCommand(new SentryService());
        });

        $this->app->bind('maintenance:import', function () {
            return new Commands\ImportCommand();
        });

        $this->app->bind('maintenance:import-dynamics', function () {
            return new Commands\Import\DynamicsCommand();
        });

        $this->commands([
            'maintenance:install',
            'maintenance:run-migrations',
            'maintenance:run-seeds',
            'maintenance:check-depends',
            'maintenance:check-schema',
            'maintenance:create-admin',
            'maintenance:import',
            'maintenance:import-dynamics',
        ]);
    }

    /**
     * Includes the required maintenance files.
     */
    private function bootRequiredFiles()
    {
        include __DIR__.'/../../routes.php';
        include __DIR__.'/../../filters.php';
        include __DIR__.'/../../composers.php';
        include __DIR__.'/../../validators.php';
        include __DIR__.'/../../listeners.php';
        include __DIR__.'/../../breadcrumbs.php';
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->missing(function () {
            return view('maintenance::404', [
                'title' => '404 - Page Not Found',
            ]);
        });

        $this->app->error(function(TokenMismatchException $exception) {
            $message = "It looks like there was a problem with the request you've sent.
                Please refresh and try again.";
            if(Request::ajax()) {
                return Response::json([
                    'message' => $message,
                    'messageType' => 'danger',
                ]);
            } else {

                $messageBag = new MessageBag();
                $messageBag->add('error', $message);

                return Redirect::back()
                    ->withInput()
                    ->withErrors($messageBag);
            }
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['maintenance'];
    }
}
