<?php

namespace Stevebauman\Maintenance\Viewers;

class EventViewer extends BaseViewer {
    
    public function profile()
    {
        return view('maintenance::viewers.events.profile', array(
            'event' => $this->entity,
        ));
    }
    
    public function btnActionsForAsset($asset)
    {
        return view('maintenance::viewers.events.buttons.actions-for-asset', array(
            'event' => $this->entity,
            'asset' => $asset,
        ));
    }
    
}