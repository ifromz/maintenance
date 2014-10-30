<?php namespace Stevebauman\Maintenance;

use Illuminate\Support\ServiceProvider;

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
                
                $this->app->bind('maintenance:install', function($app) {
                    return new Commands\InstallCommand();
                });
                $this->commands(array(
                    'maintenance:install'
                ));
                
		include __DIR__ .'/../../routes.php';
		include __DIR__ .'/../../filters.php';
		include __DIR__ .'/../../composers.php';
		include __DIR__ .'/../../validators.php';
		include __DIR__ .'/../../helpers.php';
                include __DIR__ .'/../../listeners.php';
                
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['maintenance'] = $this->app->share(function($app)
		{
			return new Maintenance($app['config']);
		});
                
                $this->app->missing(function($e){
                    return \View::make('maintenance::404', array(
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

}
