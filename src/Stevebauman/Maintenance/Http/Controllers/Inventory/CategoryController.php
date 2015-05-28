<?php

namespace Stevebauman\Maintenance\Http\Controllers\Inventory;

use Stevebauman\Maintenance\Services\Inventory\CategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Http\Controllers\AbstractNestedSetController;

class CategoryController extends AbstractNestedSetController
{
    public function __construct(
                CategoryService $inventoryCategory, CategoryValidator $categoryValidator)
    {
        $this->service = $inventoryCategory;
        $this->serviceValidator = $categoryValidator;

        $this->resource = 'Inventory Category';
    }
}
