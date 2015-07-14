<?php

namespace Stevebauman\Maintenance;

use Cartalyst\Sentinel\Laravel\SentinelServiceProvider;
use Stevebauman\Maintenance\Http\Middleware\NotAuthMiddleware;
use Stevebauman\Maintenance\Http\Middleware\PermissionMiddleware;
use Stevebauman\Maintenance\Http\Middleware\AuthMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
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
     * @param Router $router
     */
    public function boot(Router $router)
    {
        $router->middleware('maintenance.not-auth', NotAuthMiddleware::class);
        $router->middleware('maintenance.auth', AuthMiddleware::class);
        $router->middleware('maintenance.permission', PermissionMiddleware::class);

        $this->bootPublishable();

        $this->bootLoadable();

        $this->bootRequiredFiles();
    }

    /**
     * Register the service providers.
     */
    public function register()
    {
        $this->registerServiceProviders();

        $this->registerServiceAliases();

        $this->registerHandlers();
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

    /**
     * Registers publishable assets.
     */
    private function bootPublishable()
    {
        $this->publishes([
            __DIR__.'/Config/' => config_path('maintenance'),
        ], 'config');

        $this->publishes([
            __DIR__.'/Migrations/' => base_path('database/migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/stevebauman/maintenance'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../public' => public_path('assets/stevebauman/maintenance'),
        ], 'assets');
    }

    /**
     * Registers loadable assets.
     */
    private function bootLoadable()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'maintenance');

        $this->loadTranslationsFrom(__DIR__.'/Lang', 'maintenance');
    }

    /**
     * Includes the required maintenance files.
     */
    private function bootRequiredFiles()
    {
        include __DIR__.'/Registrations/routes.php';
        include __DIR__.'/Registrations/api.php';
        include __DIR__.'/Registrations/composers.php';
        include __DIR__.'/Registrations/validators.php';
        include __DIR__.'/Registrations/observers.php';
        include __DIR__.'/Registrations/breadcrumbs.php';
    }

    /**
     * Registers the service providers that the
     * maintenance application relies on.
     */
    private function registerServiceProviders()
    {
        // HTML
        $this->app->register(\Illuminate\Html\HtmlServiceProvider::class);

        // Revisions
        $this->app->register(\Stevebauman\Revision\RevisionServiceProvider::class);

        // HTML Table Generation
        $this->app->register(\Stevebauman\EloquentTable\EloquentTableServiceProvider::class);

        // Breadcrumbs
        $this->app->register(\DaveJamesMiller\Breadcrumbs\ServiceProvider::class);

        // No Captcha
        $this->app->register(\Arcanedev\NoCaptcha\Laravel\ServiceProvider::class);

        // Core Helper
        $this->app->register(\Stevebauman\CoreHelper\CoreHelperServiceProvider::class);

        // Authentication
        $this->app->register(\Cartalyst\Sentinel\Laravel\SentinelServiceProvider::class);

        // DataGrid
        $this->app->register(\Cartalyst\DataGrid\Laravel\DataGridServiceProvider::class);

        // LDAP Auth
        $this->app->register(\Stevebauman\Corp\CorpServiceProvider::class);

        // Nested Set Helper
        $this->app->register(\Baum\Providers\BaumServiceProvider::class);

        // QR Code Generator
        $this->app->register(\SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class);

        // Calendar API Helper
        $this->app->register(\Stevebauman\CalendarHelper\CalendarHelperServiceProvider::class);

        // Inventory Provider
        $this->app->register(\Stevebauman\Inventory\InventoryServiceProvider::class);

        // Log Reader / Manager
        $this->app->register(\Stevebauman\LogReader\LogReaderServiceProvider::class);

        // HTML Input Purifier
        $this->app->register(\Stevebauman\Purify\PurifyServiceProvider::class);
    }

    /**
     * Registers the laravel facades for easy access
     * for use in the maintenance application.
     */
    private function registerServiceAliases()
    {
        $loader = AliasLoader::getInstance();

        // HTML Helpers
        $loader->alias('Form', \Illuminate\Html\FormFacade::class);
        $loader->alias('HTML', \Illuminate\Html\HtmlFacade::class);

        // Authentication
        $loader->alias('Sentinel', \Cartalyst\Sentinel\Laravel\Facades\Sentinel::class);

        $loader->alias('DataGrid', \Cartalyst\DataGrid\Laravel\Facades\DataGrid::class);

        $loader->alias('QrCode', \SimpleSoftwareIO\QrCode\Facades\QrCode::class);
        $loader->alias('Breadcrumbs', \DaveJamesMiller\Breadcrumbs\Facade::class);
        $loader->alias('Captcha', \Arcanedev\NoCaptcha\Laravel\Facade::class);

        $loader->alias('Corp', \Stevebauman\Corp\Facades\Corp::class);
        $loader->alias('CalendarHelper', \Stevebauman\CalendarHelper\Facades\CalendarHelper::class);
        $loader->alias('LogReader', \Stevebauman\LogReader\Facades\LogReader::class);
        $loader->alias('Purify', \Stevebauman\Purify\Facades\Purify::class);
    }

    /**
     * Registers application handlers.
     */
    private function registerHandlers()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Stevebauman\Maintenance\Exceptions\Handler::class
        );
    }
}
