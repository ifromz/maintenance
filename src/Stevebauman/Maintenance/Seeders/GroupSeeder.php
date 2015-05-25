<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\CoreHelper\Services\ConfigService;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     * @param ConfigService $config
     */
    public function __construct(SentryService $sentry, ConfigService $config)
    {
        $this->sentry = $sentry;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Performs the seeder actions.
     */
    public function run()
    {
        $groups = $this->getSeedData();

        foreach($groups as $groupName => $routes)
        {
            $permissions = [];

            if(count($routes) > 0)
            {
                foreach($routes as $route)
                {
                    $permissions[$route] = 1;
                }
            }

            $this->sentry->createOrUpdateGroup($groupName, $permissions);
        }
    }

    /**
     * Returns the seed data to be inserted into
     * the database.
     *
     * @return array
     */
    public function getSeedData()
    {
        return $this->config->get('permissions', []);
    }
}
