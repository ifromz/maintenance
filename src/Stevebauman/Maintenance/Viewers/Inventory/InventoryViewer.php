<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class InventoryViewer extends BaseViewer {
    
    public function profile()
    {
        return view('maintenance::viewers.inventory.profile', array('item'=>$this->entity));
    }
    
    public function stock()
    {
        return view('maintenance::viewers.inventory.stock', array('item'=>$this->entity));
    }
    
    public function btnAddStock()
    {
        return view('maintenance::viewers.inventory.buttons.add-stock', array('item'=>$this->entity));
    }
    
    public function btnQrCode()
    {
        return view('maintenance::viewers.partials.buttons.qr-code', array(
            'id' => 'qr-modal',
            'title' => 'QR Code',
            'content' => route('maintenance.inventory.show', array($this->entity->id))
        ));
    }
    
    public function btnEdit()
    {
        return view('maintenance::viewers.inventory.buttons.edit', array('item'=>$this->entity));
    }
    
    public function btnDelete()
    {
        return view('maintenance::viewers.inventory.buttons.delete', array('item'=>$this->entity));
    }
    
    public function btnActions()
    {
        return view('maintenance::viewers.inventory.buttons.actions', array('item'=>$this->entity));
    }
    
    public function btnSelectForWorkOrder($workOrder)
    {
        return view('maintenance::viewers.inventory.buttons.select-work-order', array(
            'workOrder' => $workOrder,
            'item' => $this->entity
        ));
    }
    
}

