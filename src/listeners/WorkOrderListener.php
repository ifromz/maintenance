<?php

namespace Stevebauman\Maintenance\Listeners;

use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\WorkOrderNotificationService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Listeners\AbstractListener;

class WorkOrderListener extends AbstractListener {
    
    public function __construct(
            WorkOrderService $workOrder,
            WorkOrderNotificationService $workOrderNotification,
            SentryService $sentry)
    {
        $this->workOrder = $workOrder;
        $this->workOrderNotification = $workOrderNotification;
        $this->sentry = $sentry;
    }
    
    public function subscribe($events)
    {
        $events->listen('maintenance.work-orders.updates.technician.created',   'Stevebauman\Maintenance\Listeners\WorkOrderListener@onTechnicianUpdatesAdded');
        $events->listen('maintenance.work-orders.updates.customer.created',     'Stevebauman\Maintenance\Listeners\WorkOrderListener@onCustomerUpdatesAdded');
        $events->listen('maintenance.work-orders.parts.created',                'Stevebauman\Maintenance\Listeners\WorkOrderListener@onPartsAdded');
        $events->listen('maintenance.work-orders.reports.created',              'Stevebauman\Maintenance\Listeners\WorkOrderListener@onReportCreated');
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
        $notifiableUsers = $this->getNotifiableUsers($workOrder->id);
        
        if($notifiableUsers->count() > 0){
        
            foreach($notifiableUsers as $notify){
                
                if($notify->customer_updates){
                    $this->createNotification(
                            $workOrder, 
                            'Customer updates have been added to work order', 
                            route('maintenance.work-orders.show', array($workOrder->id))
                    );
                }
            }
        }
    }
    
    public function onTechnicianUpdatesAdded($workOrder)
    {
        $notifiableUsers = $this->getNotifiableUsers($workOrder->id);
        
        if($notifiableUsers->count() > 0){
        
            foreach($notifiableUsers as $notify){
                
                if($notify->technician_updates){
                    $this->createNotification(
                            $workOrder, 
                            'Technician updates have been added to work order', 
                            route('maintenance.work-orders.show', array($workOrder->id))
                    );
                }
            }
        }
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