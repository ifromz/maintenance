<?php

namespace Stevebauman\Maintenance\Repositories\WorkOrder;

use Stevebauman\Maintenance\Repositories\CategoryRepository as BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $belongsTo = 'work-orders';
}
