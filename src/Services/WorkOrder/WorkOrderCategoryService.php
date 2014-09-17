<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Models\WorkOrderCategory;

class WorkOrderCategoryService extends AbstractModelService {
	
	public function __construct(WorkOrderCategory $workOrderCategory){
		$this->model = $workOrderCategory;
	}
	
	
	
}