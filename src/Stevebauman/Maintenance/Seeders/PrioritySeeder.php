<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\PriorityService;
use Illuminate\Database\Seeder;

/**
 * Class PrioritySeeder
 * @package Stevebauman\Maintenance\Seeders
 */
class PrioritySeeder extends Seeder {

    /**
     * @var PriorityService
     */
    protected $priority;

    /**
     * @param PriorityService $priority
     */
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