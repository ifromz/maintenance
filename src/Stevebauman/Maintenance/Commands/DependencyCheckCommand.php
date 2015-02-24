<?php

namespace Stevebauman\Maintenance\Commands;

use Stevebauman\Maintenance\Exceptions\Commands\DependencyNotFoundException;
use Illuminate\Console\Command;

class DependencyCheckCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'maintenance:check-depends';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks installed packages that the maintenance application relies on';

    /**
     * Holds the dependencies that maintenance depends on
     *
     * @var array
     */
    private $dependencies = array(
        'Stevebauman\Corp\CorpServiceProvider' => 'Corp',
        'Stevebauman\Viewer\ViewerServiceProvider' => 'Viewer',
        'Stevebauman\EloquentTable\EloquentTableServiceProvider' => 'Eloquent-Table',
        'Stevebauman\Inventory\InventoryServiceProvider' => 'Inventory',
        'Stevebauman\CalendarHelper\CalendarHelperServiceProvider' => 'CalendarHelper',
        'Stevebauman\CoreHelper\CoreHelperServiceProvider' => 'Core Helper',
        'Dmyers\Storage\StorageServiceProvider' => 'Storage',
        'Cartalyst\Sentry\SentryServiceProvider' => 'Sentry',
        'JildertMiedema\LaravelPlupload\Plupload' => 'Plupload',
        'Baum\BaumServiceProvider' => 'Baum',
        'SimpleSoftwareIO\QrCode\QrCodeServiceProvider' => 'Simple-QrCode Generator',
        'Mews\Purifier\PurifierServiceProvider' => 'Purifier',
        'Mews\Captcha\CaptchaServiceProvider' => 'Captcha',
        'Google_Service' => 'Google API',
        'DaveJamesMiller\Breadcrumbs\ServiceProvider' => 'Breadcrumbs',
    );

    /**
     * Fires the command
     *
     * @throws DependencyNotFound
     */
    public function fire()
    {
        if($this->check()) {
            $this->info('Dependency check is all good!');
        }
    }

    /**
     * Checks the current project to make sure all classes that maintenance
     *
     * @return bool
     * @throws DependencyNotFoundException
     */
    private function check()
    {
        foreach($this->dependencies as $class => $name) {

            if(!class_exists($class)) {
                $message = sprintf('Dependency: %s (%s) not found. Please check your composer file', $name, $class);

                throw new DependencyNotFoundException($message);
            }

        }

        return true;
    }

}