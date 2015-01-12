<?php

namespace Stevebauman\Maintenance\Services\Inventory;

use Stevebauman\Maintenance\Exceptions\InventoryCategoryNotFoundException;
use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\CategoryService as BaseCategoryService;

class CategoryService extends BaseCategoryService
{

    protected $scoped_id = 'inventories';

    public function __construct(Category $inventoryCategory, InventoryCategoryNotFoundException $notFoundException)
    {
        $this->model = $inventoryCategory;
        $this->notFoundException = $notFoundException;
    }

}