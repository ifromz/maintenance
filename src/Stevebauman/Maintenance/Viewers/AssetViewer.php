<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class AssetViewer extends BaseViewer {
    
    public function profile()
    {
        return view('maintenance::viewers.asset.profile', array('asset'=>$this->entity));
    }
    
    public function slideshow()
    {
        return view('maintenance::viewers.asset.slideshow', array('asset'=>$this->entity));
    }
    
    public function meters()
    {
        return view('maintenance::viewers.asset.meters', array('asset'=>$this->entity));
    }
    
    public function calendar()
    {
        return view('maintenance::viewers.asset.calendar', array('asset'=>$this->entity));
    }
    
    public function btnCalendars()
    {
        return view('maintenance::viewers.asset.buttons.calendars', array('asset'=>$this->entity));
    }
    
    public function btnAddImages()
    {
        return view('maintenance::viewers.asset.buttons.add-images', array('asset'=>$this->entity));
    }
    
    public function btnViewImages()
    {
        return view('maintenance::viewers.asset.buttons.view-images', array('asset'=>$this->entity));
    }
    
    public function btnAddMeter()
    {
        return view('maintenance::viewers.asset.buttons.add-meter', array('asset'=>$this->entity));
    }
    
    public function btnEdit()
    {
        return view('maintenance::viewers.asset.buttons.edit', array('asset'=>$this->entity));
    }
    
    public function btnDelete()
    {
        return view('maintenance::viewers.asset.buttons.delete', array('asset'=>$this->entity));
    }
    
    public function btnQrCode()
    {
        return view('maintenance::viewers.partials.buttons.qr-code', array(
            'id' => 'qr-modal',
            'title' => 'QR Code',
            'content' => route('maintenance.assets.show', array($this->entity->id))
        ));
    }
    
    public function btnActions()
    {
        return view('maintenance::viewers.asset.buttons.actions', array('asset'=>$this->entity));
    }
    
}