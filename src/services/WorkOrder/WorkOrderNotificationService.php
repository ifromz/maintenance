<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\WorkOrderNotification;
use Stevebauman\Maintenance\Services\AbstractModelService;

class WorkOrderNotificationService extends AbstractModelService {
    
    public function __construct(WorkOrderNotification $model, SentryService $sentry)
    {
        $this->model = $model;
        $this->sentry = $sentry;
    }
    
    public function create()
    {
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
        
        return $this->model->create($insert);
    }
    
    public function update($id)
    {
        $record = $this->find($id);
        
        $insert = array(
            'status' => $this->getInput('status', 0),
            'priority' => $this->getInput('priority', 0),
            'parts' => $this->getInput('parts', 0),
            'customer_updates' => $this->getInput('customer_updates', 0),
            'technician_updates' => $this->getInput('technician_updates', 0),
            'completion_report' => $this->getInput('completion_report', 0)
        );
        
        return $record->update($insert);
    }
    
}