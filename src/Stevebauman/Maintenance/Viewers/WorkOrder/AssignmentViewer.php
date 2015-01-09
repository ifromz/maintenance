<?php

namespace Stevebauman\Maintenance\Viewers\WorkOrder;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class AssignmentViewer extends BaseViewer {

    public function btnRemove()
    {
        return view('maintenance::viewers.work-order.assignment.buttons.remove', array('assignment'=>$this->entity));
    }

}