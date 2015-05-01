<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\MetricService;
use Illuminate\Database\Seeder;

/**
 * Class MetricSeeder
 * @package Stevebauman\Maintenance\Seeders
 */
class MetricSeeder extends Seeder
{
    /**
     * @var MetricService
     */
    protected $metric;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param MetricService $metric
     * @param ConfigService $config
     */
    public function __construct(MetricService $metric, ConfigService $config)
    {
        $this->metric = $metric;
        $this->config = $config->setPrefix('maintenance');
    }

    /**
     * Runs the seeding operations
     *
     * @return void
     */
    public function run()
    {
        $metrics = $this->getSeedData();

        foreach($metrics as $metric)
        {
            $this->metric->setInput($metric)->firstOrCreate();
        }
    }

    /**
     * Retrieves the seed data from the maintenance configuration
     *
     * @return mixed
     */
    private function getSeedData()
    {
        return $this->config->get('seed.metrics');
    }
}
