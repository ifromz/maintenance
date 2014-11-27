<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class PriorityViewer extends BaseViewer {
    
    public function btnActions()
    {
        return view('maintenance::viewers.priority.buttons.actions', array('priority'=>$this->entity));
    }
    
}