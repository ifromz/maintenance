<?php namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Services\InventoryCategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Controllers\BaseNestedSetController;

class CategoryController extends BaseNestedSetController {
	
	public function __construct(
                InventoryCategoryService $inventoryCategory, CategoryValidator $categoryValidator){
		$this->service = $inventoryCategory;
		$this->serviceValidator = $categoryValidator;
		
                $this->resource = 'Inventory Category';
	}
	
}