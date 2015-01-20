<?php namespace Stevebauman\Maintenance;

use Illuminate\Support\ServiceProvider;
use Stevebauman\Maintenance\Services\SentryService;

class MaintenanceServiceProvider extends ServiceProvider {

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
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->missing(function($e){
			return view('maintenance::404', array(
				'title' => '404 - Not Found'
			));
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('maintenance');
	}

	private function bootCommands()
	{
		$this->app->bind('maintenance:install', function(){
					return new Commands\InstallCommand();
		});

		$this->app->bind('maintenance:run-migrations', function(){
			return new Commands\RunMigrationsCommand();
		});

		$this->app->bind('maintenance:run-seeds', function(){
			return new Commands\RunSeedsCommand();
		});

		$this->app->bind('maintenance:check-depends', function(){
			return new Commands\DependencyCheckCommand();
		});

		$this->app->bind('maintenance:check-schema', function(){
			return new Commands\SchemaCheckCommand();
		});

		$this->app->bind('maintenance:create-admin', function(){
			return new Commands\CreateAdminCommand(new SentryService);
		});

		$this->commands(array(
			'maintenance:install',
			'maintenance:run-migrations',
			'maintenance:run-seeds',
			'maintenance:check-depends',
			'maintenance:check-schema',
			'maintenance:create-admin',
		));
	}

	private function bootRequiredFiles()
	{
		include __DIR__ .'/../../routes.php';
		include __DIR__ .'/../../filters.php';
		include __DIR__ .'/../../composers.php';
		include __DIR__ .'/../../validators.php';
		include __DIR__ .'/../../listeners.php';
	}

}
