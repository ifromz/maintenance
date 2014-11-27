<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class CalendarViewer extends BaseViewer {
    
    public function btnActionsForAsset($asset)
    {
        return view('maintenance::viewers.calendar.buttons.actions-asset', array(
            'asset'=>$asset, 
            'calendar'=>$this->entity
        ));
    }
    
}