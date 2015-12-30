<?php

namespace Stevebauman\Maintenance\Seeders;

use Illuminate\Database\Seeder;
use Stevebauman\Maintenance\Repositories\WorkOrder\PriorityRepository;
use Stevebauman\Maintenance\Services\ConfigService;

class PrioritySeeder extends Seeder
{
    /**
     * @var PriorityRepository
     */
    protected $priority;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param PriorityRepository $priority
     * @param ConfigService      $config
     */
    public function __construct(PriorityRepository $priority, ConfigService $config)
    {
        $this->priority = $priority;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Runs the seeding operations.
     */
    public function run()
    {
        $priorities = $this->getSeedData();

        foreach ($priorities as $priority) {
            $this->priority->model()->create($priority);
        }
    }

    /**
     * Retrieves the seed data from the maintenance configuration.
     *
     * @return mixed
     */
    private function getSeedData()
    {
        return $this->config->get('seed.priorities');
    }
}
