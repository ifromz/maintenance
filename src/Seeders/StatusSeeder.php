<?php

namespace Stevebauman\Maintenance\Seeders;

use Illuminate\Database\Seeder;
use Stevebauman\Maintenance\Repositories\WorkOrder\StatusRepository;
use Stevebauman\Maintenance\Services\ConfigService;

class StatusSeeder extends Seeder
{
    /**
     * @var StatusRepository
     */
    protected $status;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param StatusRepository $status
     * @param ConfigService    $config
     */
    public function __construct(StatusRepository $status, ConfigService $config)
    {
        $this->status = $status;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Runs the seeding operations.
     */
    public function run()
    {
        $statuses = $this->getSeedData();

        foreach ($statuses as $status) {
            $this->status->model()->create($status);
        }
    }

    /**
     * Retrieves the seed data from the maintenance configuration.
     *
     * @return mixed
     */
    private function getSeedData()
    {
        return $this->config->get('seed.statuses');
    }
}
