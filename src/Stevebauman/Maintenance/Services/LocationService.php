<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Location;
use Stevebauman\Maintenance\Services\BaseNestedSetModelService;

class LocationService extends BaseNestedSetModelService
{

    public function __construct(Location $location)
    {
        $this->model = $location;
    }

}