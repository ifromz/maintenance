<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class StatusViewer extends BaseViewer {
    
    public function btnActions()
    {
        return view('maintenance::viewers.status.buttons.actions', array('status'=>$this->entity));
    }
    
}