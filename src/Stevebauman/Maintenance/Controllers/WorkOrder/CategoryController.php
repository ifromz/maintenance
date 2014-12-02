<?php 

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Controllers\BaseNestedSetController;
use Stevebauman\Maintenance\Services\WorkOrder\CategoryService;
use Stevebauman\Maintenance\Validators\WorkOrderCategoryValidator;

class CategoryController extends BaseNestedSetController {
	
	public function __construct(CategoryService $categoryService, WorkOrderCategoryValidator $categoryValidator){
		$this->service = $categoryService;
		$this->serviceValidator = $categoryValidator;
		
		$this->resource = 'Work Order Category';
	}

}
