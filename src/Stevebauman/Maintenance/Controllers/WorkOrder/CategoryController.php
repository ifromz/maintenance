<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\CategoryService;
use Stevebauman\Maintenance\Validators\WorkOrder\CategoryValidator;
use Stevebauman\Maintenance\Controllers\AbstractNestedSetController;

class CategoryController extends AbstractNestedSetController
{
    /**
     * Constructor.
     *
     * @param CategoryService   $categoryService
     * @param CategoryValidator $categoryValidator
     */
    public function __construct(CategoryService $categoryService, CategoryValidator $categoryValidator)
    {
        $this->service = $categoryService;
        $this->serviceValidator = $categoryValidator;

        $this->resource = 'Work Order Category';
    }
}
