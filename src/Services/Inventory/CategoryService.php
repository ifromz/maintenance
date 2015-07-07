<?php

namespace Stevebauman\Maintenance\Services\Inventory;

use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\CategoryService as BaseCategoryService;

/**
 * Class CategoryService.
 */
class CategoryService extends BaseCategoryService
{
    /**
     * @var Category
     */
    protected $model;

    protected $scoped_id = 'inventories';

    /**
     * @param Category $inventoryCategory
     */
    public function __construct(Category $inventoryCategory)
    {
        $this->model = $inventoryCategory;
    }
}
