<?php

namespace Stevebauman\Maintenance\Seeders;

use Illuminate\Database\Seeder;
use Stevebauman\Maintenance\Repositories\MetricRepository;
use Stevebauman\Maintenance\Services\ConfigService;

class MetricSeeder extends Seeder
{
    /**
     * @var MetricRepository
     */
    protected $metric;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param MetricRepository $metric
     * @param ConfigService    $config
     */
    public function __construct(MetricRepository $metric, ConfigService $config)
    {
        $this->metric = $metric;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Runs the seeding operations.
     */
    public function run()
    {
        $metrics = $this->getSeedData();

        foreach ($metrics as $metric) {
            $this->metric->model()->create($metric);
        }
    }

    /**
     * Retrieves the seed data from the maintenance configuration.
     *
     * @return mixed
     */
    private function getSeedData()
    {
        return $this->config->get('seed.metrics');
    }
}
