<?php

namespace Stevebauman\Maintenance\Repositories;

class LocationRepository extends CategoryRepository
{
    protected $belongsTo = 'locations';
}
