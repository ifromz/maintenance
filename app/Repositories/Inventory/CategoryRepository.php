<?php

namespace App\Repositories\Inventory;

use App\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'inventories';
}
