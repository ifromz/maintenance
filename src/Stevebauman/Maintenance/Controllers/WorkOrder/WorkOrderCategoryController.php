<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\BaseNestedSetController;
use Stevebauman\Maintenance\Services\WorkOrderCategoryService;
use Stevebauman\Maintenance\Validators\WorkOrderCategoryValidator;

class WorkOrderCategoryController extends BaseNestedSetController {
	
	public function __construct(WorkOrderCategoryService $categoryService, WorkOrderCategoryValidator $categoryValidator){
		$this->service = $categoryService;
		$this->serviceValidator = $categoryValidator;
		
		$this->resource = 'Work Order Category';
	}

}
