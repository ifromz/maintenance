<?php

namespace Stevebauman\Maintenance\Models\Extended;

use Venturecraft\Revisionable\RevisionableTrait;
use Stevebauman\Inventory\Models\Location as BaseLocation;

/**
 * Class Location
 * @package Stevebauman\Maintenance\Models\Extended
 */
class Location extends BaseLocation {

    use RevisionableTrait;

}
