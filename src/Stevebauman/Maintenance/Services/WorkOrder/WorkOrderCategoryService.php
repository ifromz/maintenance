<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderCategoryNotFoundException;
use Stevebauman\Maintenance\Services\BaseNestedSetModelService;
use Stevebauman\Maintenance\Models\WorkOrderCategory;

class WorkOrderCategoryService extends BaseNestedSetModelService {
	
	public function __construct(WorkOrderCategory $workOrderCategory, WorkOrderCategoryNotFoundException $notFoundException){
		$this->model = $workOrderCategory;
                $this->notFoundException = $notFoundException;
	}
        
	
}