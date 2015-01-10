<?php

namespace Stevebauman\Maintenance\Services\Inventory;

use Stevebauman\Maintenance\Models\InventoryCategory;
use Stevebauman\Maintenance\Services\BaseNestedSetModelService;

class CategoryService extends BaseNestedSetModelService
{

    public function __construct(InventoryCategory $inventoryCategory)
    {
        $this->model = $inventoryCategory;
    }

    public function roots()
    {
        return $this->model->roots()->get();
    }

}