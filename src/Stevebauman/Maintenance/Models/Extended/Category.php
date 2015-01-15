<?php

namespace Stevebauman\Maintenance\Models\Extended;

use Venturecraft\Revisionable\RevisionableTrait;
use Stevebauman\Inventory\Models\Category as BaseCategory;

/**
 * Class Category
 * @package Stevebauman\Maintenance\Models
 */
class Category extends BaseCategory {

    use RevisionableTrait;

}