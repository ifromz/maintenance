<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderCategoryNotFoundException;
use Stevebauman\Maintenance\Services\AbstractNestedSetModelService;
use Stevebauman\Maintenance\Models\WorkOrderCategory;

class WorkOrderCategoryService extends AbstractNestedSetModelService {
	
	public function __construct(WorkOrderCategory $workOrderCategory, WorkOrderCategoryNotFoundException $notFoundException){
		$this->model = $workOrderCategory;
                $this->notFoundException = $notFoundException;
	}
        
	
}