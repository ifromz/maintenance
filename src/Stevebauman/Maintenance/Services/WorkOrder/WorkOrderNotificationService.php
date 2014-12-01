<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\WorkOrderNotification;
use Stevebauman\Maintenance\Services\BaseModelService;

class WorkOrderNotificationService extends BaseModelService {
    
    public function __construct(WorkOrderNotification $model, SentryService $sentry)
    {
        $this->model = $model;
        $this->sentry = $sentry;
    }
    
    public function create()
    {
        
        $this->dbStartTransaction();
        
        try {
        
            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'work_order_id' => $this->getInput('work_order_id'),
                'status' => $this->getInput('status', 0),
                'priority' => $this->getInput('priority', 0),
                'parts' => $this->getInput('parts', 0),
                'customer_updates' => $this->getInput('customer_updates', 0),
                'technician_updates' => $this->getInput('technician_updates', 0),
                'completion_report' => $this->getInput('completion_report', 0)
            );
            
            $record = $this->model->create($insert);
            
            $this->dbCommitTransaction();
            
            return $record;
        
        } catch (Exception $e) {
            
            $this->dbRollbackTransaction();
            
            return false;
        }
    }
    
    public function update($id)
    {
        $this->dbStartTransaction();
        
        try {
        
            $record = $this->find($id);

            $insert = array(
                'status' => $this->getInput('status', 0),
                'priority' => $this->getInput('priority', 0),
                'parts' => $this->getInput('parts', 0),
                'customer_updates' => $this->getInput('customer_updates', 0),
                'technician_updates' => $this->getInput('technician_updates', 0),
                'completion_report' => $this->getInput('completion_report', 0)
            );
            
            if($record->update($insert)){
                
                $this->dbCommitTransaction();
                
                return $record;
            }
            
            $this->dbRollbackTransaction();
            
            return false;
        
        } catch (Exception $e) {
            
            $this->dbCommitTransaction();
            
            return false;
        }
    }
    
}