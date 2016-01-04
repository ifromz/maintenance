<?php

namespace App\Services;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\Filesystem;

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
     * Stores the prefix for accessing package configuration values
     *
     * @var string
     */
    protected $prefix = '';

    /**
     * Stores the prefix separator
     *
     * @var string
     */
    protected $prefixSeparator = '.';

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
     * @param int|string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = NULL)
    {
        return $this->config->get($this->prefix.$key, $default);
    }

    /**
     * Sets a configuration by the specified key
     *
     * @param $key
     * @param $value
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $this->config->set($this->prefix.$key, $value);

        return $this;
    }

    /**
     * Sets the prefix property
     *
     * @param string $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix = '')
    {
        $this->prefix = $prefix.$this->prefixSeparator;

        return $this;
    }

    /**
     * Sets the prefix separator
     *
     * @param string $separator
     *
     * @return $this
     */
    public function setPrefixSeparator($separator = '')
    {
        $this->prefixSeparator = $separator;

        return $this;
    }

    /**
     * Updates the maintenance site configuration file.
     *
     * @return bool
     */
    public function updateSite()
    {
        /*
         * Set the site configuration path
         */
        $siteConfig = 'maintenance/site.php';

        $content = $this->getConfigFile($siteConfig);

        $content = $this->replaceConfigEntry($content, 'main', 'maintenance.site.title.main', $this->getInput('title'));
        $content = $this->replaceConfigEntry($content, 'admin', 'maintenance.site.title.admin', $this->getInput('admin_title'));
        $content = $this->replaceConfigEntry($content, 'work-orders', 'maintenance.site.calendars.work-orders', $this->getInput('work_order_calendar'));
        $content = $this->replaceConfigEntry($content, 'inventories', 'maintenance.site.calendars.inventories', $this->getInput('inventory_calendar'));
        $content = $this->replaceConfigEntry($content, 'assets', 'maintenance.site.calendars.assets', $this->getInput('asset_calendar'));

        /*
         * Put the updated content back inside
         * the config file and return the result
         */
        return $this->setConfigFile($siteConfig, $content);
    }

    /**
     * Updates the laravel mail configuration file.
     *
     * @return bool
     */
    public function updateMail()
    {
        /*
         * Set the mail configuration file path
         */
        $mailConfig = 'mail.php';

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
            ($this->getInput('smtp_password') ? $this->getInput('smtp_password') : $this->get('mail.password'))
        );

        $content = $this->replaceConfigEntry($content, 'host', 'mail.host', $this->getInput('host_ip'));
        $content = $this->replaceConfigEntry($content, 'port', 'mail.port', $this->getInput('host_port'), 'integer');
        $content = $this->replaceConfigEntry($content, 'address', 'mail.from.address', $this->getInput('global_email'));
        $content = $this->replaceConfigEntry($content, 'name', 'mail.from.name', $this->getInput('global_name'));
        $content = $this->replaceConfigEntry($content, 'encryption', 'mail.encryption', $this->getInput('encryption'));

        $pretend = false;
        if ($this->getInput('pretend')) {
            $pretend = true;
        }

        $content = $this->replaceConfigEntry($content, 'pretend', 'mail.pretend', $pretend, 'bool');

        /*
         * Put the updated content back inside
         * the config file and return the result
         */
        return $this->setConfigFile($mailConfig, $content);
    }

    /**
     * Replaces content from configuration files and returns the result content
     *
     * @param $content
     * @param $name
     * @param $entry
     * @param string $value
     * @param string $type
     *
     * @return mixed
     */
    protected function replaceConfigEntry($content, $name, $entry, $value = "''", $type = 'string')
    {
        switch($type)
        {
            case 'string':

                $oldEntry = sprintf("'$name' => '%s'", addslashes($this->get($entry)));
                $newEntry = sprintf("'$name' => '%s'", addslashes($value));

                return str_replace($oldEntry, $newEntry, $content);
            case 'integer':

                $oldEntry = sprintf("'$name' => %s", $this->get($entry));
                $newEntry = sprintf("'$name' => %s", $value);

                return str_replace($oldEntry, $newEntry, $content);
            case 'bool':
                $oldEntry = sprintf("'$name' => %s", var_export($this->get($entry), true));
                $newEntry = sprintf("'$name' => %s", var_export($value, true));

                return str_replace($oldEntry, $newEntry, $content);
            default:
                return $content;
        }
    }

    /**
     * Returns the contents of the specified file path.
     *
     * @param $path
     *
     * @return string
     *
     * @throws \Illuminate\Filesystem\FileNotFoundException
     */
    protected function getConfigFile($path)
    {
        return $this->filesystem->get(config_path($path));
    }

    /**
     * Inserts the specified content into the config
     * file that exists in the specified path.
     *
     * @param string $path
     * @param string $content
     *
     * @return bool
     */
    protected function setConfigFile($path, $content)
    {
        if($this->filesystem->put(config_path($path), $content)) return true;

        return false;
    }
}
