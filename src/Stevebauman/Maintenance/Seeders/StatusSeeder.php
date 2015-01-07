<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\StatusService;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder {

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