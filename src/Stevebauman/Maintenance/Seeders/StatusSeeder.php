<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\StatusService;
use Illuminate\Database\Seeder;

/**
 * Class StatusSeeder
 * @package Stevebauman\Maintenance\Seeders
 */
class StatusSeeder extends Seeder {

    /**
     * @var StatusService
     */
    protected $status;

    /**
     * @param StatusService $status
     */
    public function __construct(StatusService $status)
    {
        $this->status = $status;
    }

    public function run()
    {
        $statuses = $this->getSeedData();

        foreach($statuses as $status) {

            $this->status->setInput($status)->firstOrCreate();

        }
    }

    private function getSeedData()
    {
        return config('maintenance::seed.statuses');
    }

}