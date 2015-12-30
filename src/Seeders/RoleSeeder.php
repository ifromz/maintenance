<?php

namespace Stevebauman\Maintenance\Seeders;

use Illuminate\Database\Seeder;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;

class RoleSeeder extends Seeder
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
        $roles = $this->getSeedData();

        foreach ($roles as $roleName => $permissions) {
            $this->sentry->createOrUpdateRole($roleName, $permissions);
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
