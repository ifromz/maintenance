<?php

namespace Stevebauman\Maintenance\Notifiers;

use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Notifiers\NotifierInterface;

class WorkOrderNotifier implements NotifierInterface {
    
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }
    
    public function handleRevision($revision)
    {
        
        /*
         * Get the work order that was modified
         */
        $workOrder = $this->workOrder->find($revision['revisionable_id']);
        
        /*
         * Get the users that have notifcations set for the specific work order
         */
        $notifiableUsers = $workOrder->notifiableUsers()->get();
        
        /*
         * If notifications exist
         */
        if($notifiableUsers->count() > 0){
            
            /*
             * For each user set with notifications
             */
            foreach($notifiableUsers as $notify){

                /*
                 * Check each key to see if a user should be notified about the
                 * change
                 */
                switch($revision['key']){

                    case 'status_id':

                        /*
                         * Check if the user is set to be notified about the status
                         */
                        if($notify->status){

                            /*
                             * Send the notification
                             */
                            $this->notifyStatusChange($workOrder, $notify);
                        }

                        break;
                        
                    case 'priority_id':
                        
                        if($notify->priority){
                            $this->notifyPriorityChange($workOrder, $notify);
                        }
                        
                        break;
                        
                    default:
                        break;
                }

            }
        
        }
        
    }
    
    public function notifyStatusChange($workOrder, $notify)
    {
        $workOrder->notifications()->create(array(
            'user_id' => $notify->user_id,
            'message' => 'Status has been changed',
            'link' => 'test',
        ));
    }
    
    public function notifyPriorityChange($workOrder, $notify)
    {
        $workOrder->notifications()->create(array(
            'user_id' => $notify->user_id,
            'message' => 'Priority has been changed',
            'link' => 'test',
        ));
    }
    
    public function notifyPartsAdded($workOrder, $notify)
    {
        $workOrder->notifications()->create(array(
            'user_id' => $notify->user_id,
            'message' => 'Parts have been added to work order',
            'link' => 'test',
        ));
    }
    
    public function notiftyReportCreated($workOrder, $notify)
    {
        $workOrder->notifications()->create(array(
            'user_id' => $notify->user_id,
            'message' => 'A completion report has been created',
            'link' => 'test',
        ));
    }
    
    public function notiftyTechUpdatesAdded($workOrder, $notify)
    {
        $workOrder->notifications()->create(array(
            'user_id' => $notify->user_id,
            'message' => 'A new technician update was added',
            'link' => 'test',
        ));
    }
    
    public function notiftyCustUpdatesAdded($workOrder, $notify)
    {
        $workOrder->notifications()->create(array(
            'user_id' => $notify->user_id,
            'message' => 'A new customer updated was added',
            'link' => 'test',
        ));
    }
    
}