<?php

namespace Stevebauman\Maintenance\Seeders;

use Stevebauman\Maintenance\Services\LocationService;
use Illuminate\Database\Seeder;

/**
 * Class LocationSeeder
 * @package Stevebauman\Maintenance\Seeders
 */
class LocationSeeder extends Seeder
{
    /**
     * @var LocationService
     */
    protected $location;

    /**
     * Constructor.
     *
     * @param LocationService $location
     */
    public function __construct(LocationService $location)
    {
        $this->location = $location;
    }
}
