<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Location;

/**
 * Class LocationService.
 */
class LocationService extends BaseNestedSetModelService
{
    public function __construct(Location $location)
    {
        $this->model = $location;
    }
}
