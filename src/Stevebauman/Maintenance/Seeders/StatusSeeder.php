<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\StatusService;
use Illuminate\Database\Seeder;

/**
 * Class StatusSeeder
 * @package Stevebauman\Maintenance\Seeders
 */
class StatusSeeder extends Seeder
{
    /**
     * @var StatusService
     */
    protected $status;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param StatusService $status
     * @param ConfigService $config
     */
    public function __construct(StatusService $status, ConfigService $config)
    {
        $this->status = $status;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Runs the seeding operations
     *
     * @return void
     */
    public function run()
    {
        $statuses = $this->getSeedData();

        foreach($statuses as $status)
        {
            $this->status->setInput($status)->firstOrCreate();
        }
    }

    /**
     * Retrieves the seed data from the maintenance configuration
     *
     * @return mixed
     */
    private function getSeedData()
    {
        return $this->config->get('seed.statuses');
    }

}