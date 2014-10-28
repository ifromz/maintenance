<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Exceptions\WorkRequestNotFoundException;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\PriorityService;
use Stevebauman\Maintenance\Services\StatusService;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Services\AbstractModelService;

class WorkOrderPublicService extends AbstractModelService {
    
    public function __construct(
            WorkOrder $workOrder, 
            StatusService $status, 
            PriorityService $priority,
            SentryService $sentry,
            WorkRequestNotFoundException $notFoundException)
    {
        $this->model = $workOrder;
        $this->status = $status;
        $this->priority = $priority;
        $this->sentry = $sentry;
        $this->notFoundException = $notFoundException;
    }
    
    /**
     * Returns an eloquent collection of the current logged in users
     * work orders
     */
    public function getByPageByUser()
    {
        return $this->model->where('user_id', $this->sentry->getCurrentUserId())->paginate(25);
    }
    
     public function create()
        {
            $status = $this->status->firstOrCreateRequest();
            $priority = $this->priority->firstOrCreateRequest();
            
            $insert = array(
                'status_id'     => $status->id,
                'priority_id'   => $priority->id,
                'user_id'       => $this->sentry->getCurrentUserId(),
                'subject'       => $this->getInput('subject', NULL, true),
                'description'   => $this->getInput('description', NULL, true),
            );
            
            $record = $this->model->create($insert);
            
            return $record;
        }
        
        public function update($id)
        {
            $record = $this->find($id);
            
            $insert = array(
                'subject'       => $this->getInput('subject', $record->subject, true),
                'description'   => $this->getInput('description', $record->description, true)
            );
            
            if($record->update($insert)){
                return $record;
            } else{
                return false;
            }
        }
        
        /**
         * Only allow users to delete their own requests
         * 
         * @param integer $id
         */
        public function destroy($id)
        {
            $record = $this->find($id);
            
            /*
             * Make sure the current logged in User ID equals the work order
             * user id
             */
            if($record->user_id === $this->sentry->getCurrentUserId()){
                $record->delete();
                
                return true;
                
            } else{
                return false;
            }
        }

}