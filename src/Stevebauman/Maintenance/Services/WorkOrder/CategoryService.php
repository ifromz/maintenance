<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Stevebauman\Maintenance\Exceptions\WorkOrderCategoryNotFoundException;
use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\CategoryService as BaseCategoryService;

class CategoryService extends BaseCategoryService
{

    protected $scoped_id = 'work_orders';

    public function __construct(Category $workOrderCategory, WorkOrderCategoryNotFoundException $notFoundException)
    {
        $this->model = $workOrderCategory;
        $this->notFoundException = $notFoundException;
    }


}