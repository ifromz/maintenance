<?php

namespace Stevebauman\Maintenance\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Config\Repository as Config;
use Stevebauman\CoreHelper\Services\Service;

/**
 * Class ConfigService
 * @package Stevebauman\Maintenance\Services
 */
class ConfigService extends Service
{

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @param Config $config
     * @param Filesystem $filesystem
     */
    public function __construct(Config $config, Filesystem $filesystem)
    {
        $this->config = $config;
        $this->filesystem = $filesystem;
    }

    /**
     * Retrieves the specified key from the current configuration
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key, $default)
    {
        return $this->config->get($key, $default);
    }

    /**
     * Sets a configuration by the specified key
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key, $value)
    {
        $this->config->set($key, $value);

        return true;
    }

    /**
     * Updates the maintenance site configuration file
     *
     * @return bool
     */
    public function updateSite()
    {
        /*
         * Set the site configuration path
         */
        $siteConfig = 'config/packages/stevebauman/maintenance/site.php';

        $content = $this->getConfigFile($siteConfig);

        $content = $this->replaceConfigEntry($content, 'main', 'maintenance::site.title.main', $this->getInput('title'));
        $content = $this->replaceConfigEntry($content, 'admin', 'maintenance::site.title.admin', $this->getInput('admin_title'));
        $content = $this->replaceConfigEntry($content, 'work-orders', 'maintenance::site.calendars.work-orders', $this->getInput('work_order_calendar'));
        $content = $this->replaceConfigEntry($content, 'inventories', 'maintenance::site.calendars.inventories', $this->getInput('inventory_calendar'));
        $content = $this->replaceConfigEntry($content, 'assets', 'maintenance::site.calendars.assets', $this->getInput('asset_calendar'));

        /*
         * Set put the content back inside the file
         */
        if($this->setConfigFile($siteConfig, $content)) return true;

        return false;
    }

    /**
     * Updates the laravel mail configuration file
     *
     * @return bool
     */
    public function updateMail()
    {
        /*
         * Set the mail configuration file path
         */
        $mailConfig = 'config/mail.php';

        /*
         * Get the content from the configuration file
         */
        $content = $this->getConfigFile($mailConfig);

        /*
         * Replace configuration entries inside the config content
         */
        $content = $this->replaceConfigEntry($content, 'driver', 'mail.driver', $this->getInput('mail_driver'));
        $content = $this->replaceConfigEntry($content, 'username', 'mail.username', $this->getInput('smtp_username'));

        /*
         * Since we can't pre-populate the password field we need to make sure
         * that we default the config password to it's current so it's
         * not overwritten with a blank field
         */
        $content = $this->replaceConfigEntry($content, 'password', 'mail.password',
            ($this->getInput('smtp_password') ? $this->getInput('smtp_password') : config('mail.password'))
        );

        $content = $this->replaceConfigEntry($content, 'host', 'mail.host', $this->getInput('host_ip'));
        $content = $this->replaceConfigEntry($content, 'port', 'mail.port', $this->getInput('host_port'), 'integer');
        $content = $this->replaceConfigEntry($content, 'address', 'mail.from.address', $this->getInput('global_email'));
        $content = $this->replaceConfigEntry($content, 'name', 'mail.from.name', $this->getInput('global_name'));
        $content = $this->replaceConfigEntry($content, 'encryption', 'mail.encryption', $this->getInput('encryption'));

        $pretend = false;
        if($this->getInput('pretend')) $pretend = true;

        $content = $this->replaceConfigEntry($content, 'pretend', 'mail.pretend', $pretend, 'bool');

        /*
         *  Put the content back inside the file
         */
        if($this->setConfigFile($mailConfig, $content)) return true;

        return false;
    }

    /**
     * Replaces content from configuration files and returns the result content
     *
     * @param $content
     * @param $name
     * @param $entry
     * @param string $value
     * @param string $type
     * @return mixed
     */
    private function replaceConfigEntry($content, $name, $entry, $value = "''", $type = 'string')
    {
        switch($type)
        {
            case 'string':

                $oldEntry = sprintf("'$name' => '%s'", addslashes(config($entry)));
                $newEntry = sprintf("'$name' => '%s'", addslashes($value));

                return str_replace($oldEntry, $newEntry, $content);

                break;
            case 'integer':

                $oldEntry = sprintf("'$name' => %s", config($entry));
                $newEntry = sprintf("'$name' => %s", $value);

                return str_replace($oldEntry, $newEntry, $content);

                break;
            case 'bool':
                $oldEntry = sprintf("'$name' => %s", var_export(config($entry), true));
                $newEntry = sprintf("'$name' => %s", var_export($value, true));

                return str_replace($oldEntry, $newEntry, $content);

                break;
            default:

                return $content;
                break;
        }
    }

    /**
     * Returns the contents of the specified file path
     *
     * @param $path
     * @return string
     * @throws \Illuminate\Filesystem\FileNotFoundException
     */
    private function getConfigFile($path)
    {
        return $this->filesystem->get(app_path($path));
    }

    /**
     * @param $path
     * @param $content
     * @return int
     */
    private function setConfigFile($path, $content)
    {
        return $this->filesystem->put(app_path($path), $content);
    }
}