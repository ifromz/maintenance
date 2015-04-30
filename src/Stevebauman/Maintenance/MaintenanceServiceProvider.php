<?php

namespace Stevebauman\Maintenance;

use Stevebauman\Maintenance\Services\SentryService;
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
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('stevebauman/maintenance');

		$this->bootCommands();

		$this->bootRequiredFiles();
	}

	/**
	 * Registers all the maintenance commands
	 *
	 * @return void
	 */
	private function bootCommands()
	{
		$this->app->bind('maintenance:install', function() {
			return new Commands\InstallCommand;
		});

		$this->app->bind('maintenance:run-migrations', function() {
			return new Commands\RunMigrationsCommand;
		});

		$this->app->bind('maintenance:run-seeds', function() {
			return new Commands\RunSeedsCommand;
		});

		$this->app->bind('maintenance:check-depends', function() {
			return new Commands\DependencyCheckCommand;
		});

		$this->app->bind('maintenance:check-schema', function() {
			return new Commands\SchemaCheckCommand;
		});

		$this->app->bind('maintenance:create-admin', function() {
			return new Commands\CreateAdminCommand(new SentryService);
		});

		$this->app->bind('maintenance:import', function() {
			return new Commands\ImportCommand;
		});

		$this->app->bind('maintenance:import-dynamics', function() {
			return new Commands\Import\DynamicsCommand;
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
	 * Includes the required maintenance files
	 *
	 * @return void
	 */
	private function bootRequiredFiles()
	{
		include __DIR__ .'/../../routes.php';
		include __DIR__ .'/../../filters.php';
		include __DIR__ .'/../../composers.php';
		include __DIR__ .'/../../validators.php';
		include __DIR__ .'/../../listeners.php';
		include __DIR__ .'/../../breadcrumbs.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->missing(function($e)
        {
			return view('maintenance::404', [
				'title' => '404 - Page Not Found'
            ]);
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
