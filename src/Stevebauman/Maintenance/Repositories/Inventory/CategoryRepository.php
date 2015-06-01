<?php

namespace Stevebauman\Maintenance\Repositories\Inventory;

use Stevebauman\Maintenance\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'inventories';
}
