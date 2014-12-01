<?php 

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Controllers\BaseNestedSetController;
use Stevebauman\Maintenance\Services\WorkOrderCategoryService;
use Stevebauman\Maintenance\Validators\WorkOrderCategoryValidator;

class CategoryController extends BaseNestedSetController {
	
	public function __construct(WorkOrderCategoryService $categoryService, WorkOrderCategoryValidator $categoryValidator){
		$this->service = $categoryService;
		$this->serviceValidator = $categoryValidator;
		
		$this->resource = 'Work Order Category';
	}

}
