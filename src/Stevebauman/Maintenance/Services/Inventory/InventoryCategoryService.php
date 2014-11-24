<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\InventoryCategory;
use Stevebauman\Maintenance\Services\AbstractNestedSetModelService;

class InventoryCategoryService extends AbstractNestedSetModelService {
    
    public function __construct(InventoryCategory $inventoryCategory)
    {
        $this->model = $inventoryCategory;
    }
    
    public function roots()
    {
        return $this->model->roots()->get();
    }
    
}