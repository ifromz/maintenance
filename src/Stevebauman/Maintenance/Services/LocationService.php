<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Location;

/**
 * Class LocationService
 * @package Stevebauman\Maintenance\Services
 */
class LocationService extends BaseNestedSetModelService
{
    public function __construct(Location $location)
    {
        $this->model = $location;
    }
}