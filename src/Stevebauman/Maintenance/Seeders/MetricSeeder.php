<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\MetricService;
use Illuminate\Database\Seeder;

class MetricSeeder extends Seeder {

    public function __construct(MetricService $metric)
    {
        $this->metric = $metric;
    }

    public function run()
    {
        $metrics = $this->getSeedData();

        foreach($metrics as $metric) {

            $this->metric->setInput($metric)->firstOrCreate();

        }
    }

    private function getSeedData()
    {
        return config('maintenance::seed.metrics');
    }

}