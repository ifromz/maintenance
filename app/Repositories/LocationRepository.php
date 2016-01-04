<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository extends CategoryRepository
{
    /**
     * The scoped belongsTo attribute.
     *
     * @var string
     */
    protected $belongsTo = 'locations';

    /**
     * @return Location
     */
    public function model()
    {
        return new Location();
    }
}
