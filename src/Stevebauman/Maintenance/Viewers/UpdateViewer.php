<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class UpdateViewer extends BaseViewer {
    
    public function workOrderCustomer($workOrder)
    {
        return view('maintenance::viewers.update.work-order.customer', array(
            'workOrder' => $workOrder,
            'update' => $this->entity,
        ));
    }
    
    public function workOrderTechnician($workOrder)
    {
        return view('maintenance::viewers.update.work-order.technician', array(
            'workOrder' => $workOrder,
            'update' => $this->entity,
        ));
    }
    
}