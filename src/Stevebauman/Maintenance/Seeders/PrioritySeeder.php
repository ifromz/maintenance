<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\PriorityService;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder {

    public function __construct(PriorityService $priority)
    {
        $this->priority = $priority;
    }

    public function run()
    {
        $priorities = $this->getSeedData();

        foreach($priorities as $prioritiy) {

            $this->priority->setInput($prioritiy)->firstOrCreate();

        }
    }

    private function getSeedData()
    {
        return config('maintenance::seed.priorities');
    }

}