<?php

namespace Stevebauman\Maintenance\Listeners;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Listeners\AbstractListener;

class WorkOrderListener extends AbstractListener {
    
    public function __construct(
            WorkOrderNotifier $notifier, 
            WorkOrderService $workOrder,
            SentryService $sentry)
    {
        $this->notifier = $notifier;
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
    }
    
    public function onPartsAdded($workOrder, $stock)
    {
        $notifiableUsers = $this->getNotifiableUsers($workOrder->id);
        
        if($notifiableUsers->count() > 0){
        
            foreach($notifiableUsers as $notify){
                
                if($notify->parts){
                    $this->createNotification(
                            $workOrder, 
                            'Parts have been added work order', 
                            route('maintenance.work-orders.show', array($workOrder->id))
                    );
                }
            }
        }
    }
    
    public function onCustomerUpdatesAdded($workOrder)
    {
        
    }
    
    public function onTechnicianUpdatesAdded($workOrder)
    {
        
    }
    
    public function onReportCreated($report)
    {   
        $notifiableUsers = $this->getNotifiableUsers($report->workOrder->id);
        
        if($notifiableUsers->count() > 0){
        
            foreach($notifiableUsers as $notify){
                
                if($notify->completion_report){
                    
                    $this->createNotification(
                            $report->workOrder, 
                            'Parts have been added work order', 
                            route('maintenance.work-orders.show', array($report->workOrder->id))
                    );
                    
                }
            }
        }
        
    }
    
    public function subscribe($events)
    {
        
        $events->listen('maintenance.work-orders.parts.created', 'Stevebauman\Maintenance\Listeners\WorkOrderListener@onPartsAdded');
        $events->listen('maintenance.work-orders.reports.created', 'Stevebauman\Maintenance\Listeners\WorkOrderListener@onReportCreated');
    }
    
    private function getNotifiableUsers($workOrder_id)
    {
        /*
         * Returns notifiable users but removes the current user since
         * they are the ones who made the change
         */
        return $this->workOrderNotification
                ->where('work_order_id', $workOrder_id)
                ->where('user_id', '!=', $this->sentry->getCurrentUserId())
                ->get();
    }
    
}