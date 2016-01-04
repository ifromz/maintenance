<?php

namespace App\Repositories\WorkOrder;

use App\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'work-orders';
}
