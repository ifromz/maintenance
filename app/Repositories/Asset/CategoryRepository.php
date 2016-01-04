<?php

namespace App\Repositories\Asset;

use App\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * The scoped belongs to attribute.
     *
     * @var string
     */
    protected $belongsTo = 'assets';
}
