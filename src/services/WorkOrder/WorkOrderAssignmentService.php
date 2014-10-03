<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderAssignmentNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Models\WorkOrderAssignment;

class WorkOrderAssignmentService extends AbstractModelService {
	
	public function __construct(WorkOrderAssignment $assignment, SentryService $sentry, WorkOrderAssignmentNotFoundException $notFoundException){
		$this->model = $assignment;
                $this->sentry = $sentry;
                $this->notFoundException = $notFoundException;
	}
        
        public function create($workOrder_id){
            if($users = $this->input('users')){
                
                $records = array();
                
                foreach($users as $user){
                    
                    $insert = array(
                        'work_order_id' => $workOrder_id,
                        'by_user_id' => $this->sentry->getCurrentUserId(),
                        'to_user_id' => $user
                    );
                    
                    if($records[] = $this->model->create($insert)){
                        
                    } else{
                        return false;
                    }
                }
                
                return $records;
                
            }
            
        }
	
}