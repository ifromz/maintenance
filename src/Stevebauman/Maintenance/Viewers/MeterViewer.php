<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class MeterViewer extends BaseViewer {
    
    public function btnActionsForAsset($asset)
    {
        return view('maintenance::viewers.meter.buttons.actions-asset', array('asset'=>$asset, 'meter'=>$this->entity));
    }
    
}

