<?php

namespace Stevebauman\Maintenance\Repositories;

use Stevebauman\Maintenance\Models\Location;

class LocationRepository extends CategoryRepository
{
    protected $belongsTo = 'locations';

    /**
     * @return Location
     */
    public function model()
    {
        return new Location();
    }
}
