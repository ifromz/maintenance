<?php

namespace Stevebauman\Maintenance\Viewers;

class AttachmentViewer extends BaseViewer {
    
    
    
    public function btnActionsForAssetManual($asset)
    {
        return view('maintenance::viewers.attachments.buttons.actions-asset-manual', array(
            'asset'=>$asset, 
            'manual'=>$this->entity
        ));
    }
    
    public function btnActionsForAssetImage($asset)
    {
        return view('maintenance::viewers.attachments.buttons.actions-asset-image', array(
            'asset'=>$asset, 
            'image'=>$this->entity
        ));
    }
    
}