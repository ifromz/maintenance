<?php namespace Stevebauman\Maintenance\Observers;

use Stevebauman\Maintenance\Observers\AbstractObserver;

class WorkOrderAssignmentObserver extends AbstractObserver {
    
    public function created($record){

        $notification = array(
            'user_id' => $record->to_user_id,
            'message' => sprintf('%s has assigned you to a work order', $record->byUser->full_name),
            'link' => route('maintenance.work-orders.show', array($record->work_order_id)),
            'notifiable_id' => $record->id,
            'notifiable_type'=> get_class($record),
        );
        
        $record->notifications()->create($notification);
        
    }
    
}