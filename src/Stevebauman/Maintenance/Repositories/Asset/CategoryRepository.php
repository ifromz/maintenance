<?php

namespace Stevebauman\Maintenance\Repositories\Asset;

use Stevebauman\Maintenance\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'assets';
}
