<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\CategoryService;
use Stevebauman\Maintenance\Validators\WorkOrderCategoryValidator;
use Stevebauman\Maintenance\Controllers\AbstractNestedSetController;

class CategoryController extends AbstractNestedSetController
{

    public function __construct(CategoryService $categoryService, WorkOrderCategoryValidator $categoryValidator)
    {
        $this->service = $categoryService;
        $this->serviceValidator = $categoryValidator;

        $this->resource = 'Work Order Category';
    }

}
