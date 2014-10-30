<?php

namespace Stevebauman\Maintenance\Listeners;

use Stevebauman\Maintenance\Notifiers\WorkOrderNotifier;

class RevisionListener {
    
    public function __construct(WorkOrderNotifier $workOrder)
    {
        $this->workOrder = $workOrder;
    }
    
    public function handle($revisions)
    {
        foreach($revisions as $revision){
            
            $notifier = '';
            
            switch($revision['revisionable_type'])
            {
                case 'Stevebauman\Maintenance\Models\WorkOrder':
                    $notifier = $this->workOrder;
                    break;
                
            }
            
            if(is_object($notifier)){
                $notifier->handle($revision);
            }
        }
    }
    
}