<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkOrderAssignmentNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;
use Stevebauman\Maintenance\Models\WorkOrderAssignment;

class WorkOrderAssignmentService extends BaseModelService {
	
	public function __construct(WorkOrderAssignment $assignment, SentryService $sentry, WorkOrderAssignmentNotFoundException $notFoundException){
		$this->model = $assignment;
                $this->sentry = $sentry;
                $this->notFoundException = $notFoundException;
	}
        
        public function create()
        {
            
            $this->dbStartTransaction();
            
            try {
                
                $users = $this->getInput('users');

                if($users) {

                    $records = array();

                    foreach($users as $user){

                        $insert = array(
                            'work_order_id' => $this->getInput('work_order_id'),
                            'by_user_id' => $this->sentry->getCurrentUserId(),
                            'to_user_id' => $user
                        );

                        $records[] = $this->model->create($insert);
                        
                    }
                    
                    $this->dbCommitTransaction();
                    
                    return $records;

                }

                return false;
            
            } catch (Exception $e) {
                
                $this->dbRollbackTransaction();
                
                return false;
            }
            
        }
	
}