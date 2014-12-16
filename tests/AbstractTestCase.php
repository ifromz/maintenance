<?php
namespace Stevebauman\Maintenance\Tests;

use Mockery;
use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase 
{
    
    public function getPackageProviders() 
    {
        return array(
            'Stevebauman\Corp\CorpServiceProvider', // LDAP Authentication
            'Stevebauman\Maintenance\MaintenanceServiceProvider', // Maintenance Application
            'Stevebauman\EloquentTable\EloquentTableServiceProvider', // Dynamic Table generation
            'Stevebauman\CoreHelper\CoreHelperServiceProvider', //Core helper services
            'Stevebauman\CalendarHelper\CalendarHelperServiceProvider',
            'Stevebauman\Location\LocationServiceProvider',

            'Cartalyst\Sentry\SentryServiceProvider', // Authentication
            'JildertMiedema\LaravelPlupload\LaravelPluploadServiceProvider', // Dynamic Javascript Uploads
            'Baum\BaumServiceProvider', // Nested Set Provider
            'Dmyers\Storage\StorageServiceProvider', // Attachment / Upload Helper
            'Mews\Purifier\PurifierServiceProvider', // HTML purifier for displaying user inputted text
            'SimpleSoftwareIO\QrCode\QrCodeServiceProvider', //QR Code Generator
            'Mews\Captcha\CaptchaServiceProvider', // Captcha for registration,  
        );
    }
    
    public function getPackageAliases()
    {
        return array(
            'Location' => 'Stevebauman\Location\Facades\Location',

            'Sentry'    => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
            'Corp'      => 'Stevebauman\Corp\Facades\Corp',
            'CalendarHelper' => 'Stevebauman\CalendarHelper\Facades\CalendarHelper',
            'Plupload'  => 'JildertMiedema\LaravelPlupload\Facades\Plupload',
            'Storage'   => 'Dmyers\Storage\Storage',
            'Purifier'  => 'Mews\Purifier\Facades\Purifier',
            'QrCode'    => 'SimpleSoftwareIO\QrCode\Facades\QrCode',
            'Captcha'   => 'Mews\Captcha\Facades\Captcha',  
        );
    }
    
    public function mock($class)
    {
      $mock = Mockery::mock($class);

      $this->app->instance($class, $mock);

      return $mock;
    }
    
    public function tearDown() {
        Mockery::close();
    }
    
}