<?php

namespace Stevebauman\Maintenance\Listeners;

use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Notifiers\WorkOrderNotifier;

class WorkOrderListener {
    
    public function __construct(WorkOrderNotifier $notifier, WorkOrderService $workOrder)
    {
        $this->notifier = $notifier;
        $this->workOrder = $workOrder;
    }
    
    public function onCreated($workOrder)
    {
        
    }
    
    public function onDestroyed($workOrder)
    {
        
    }
    
    public function onPartsAdded($workOrder)
    {
        
    }
    
    public function onReportCreated($report)
    {   
        $notifiableUsers = $report->workOrder->notifiableUsers()->get();
        
        if($notifiableUsers->count() > 0){
        
            foreach($notifiableUsers as $notify){

                if($notify->completion_report){

                    $this->notifier->notiftyReportCreated($report->workOrder, $notify);
                }
            }
        }
        
    }
    
    public function subscribe($events)
    {

        $events->listen('maintenance.work-orders.reports.created', 'Stevebauman\Maintenance\Listeners\WorkOrderListener@onReportCreated');
    }
    
}