<?php namespace Stevebauman\Maintenance\Observers;

use Stevebauman\Maintenance\Observers\AbstractObserver;

class WorkOrderObserver extends AbstractObserver {
    
    public function saving($model)
    {
        //
    }
    
    public function saved($record){
        /*
        $record->notifications()->create(array(
            'user_id' => $record->user_id,
            'message' => 'Work Order has been saved',
            'link' => route('maintenance.work-orders.show', array($record->id)),
            'notifiable_id' => $record->id,
            'notifiable_type' => get_class($record),
        ));
         * 
         */
        
    }
    
}