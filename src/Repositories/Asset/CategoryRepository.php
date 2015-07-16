<?php

namespace Stevebauman\Maintenance\Repositories\Asset;

use Stevebauman\Maintenance\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * The scoped belongs to attribute.
     *
     * @var string
     */
    protected $belongsTo = 'assets';
}
