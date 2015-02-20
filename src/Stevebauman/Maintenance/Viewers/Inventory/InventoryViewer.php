<?php

namespace Stevebauman\Maintenance\Viewers\Inventory;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class InventoryViewer extends BaseViewer {
    
    public function profile()
    {
        return view('maintenance::viewers.inventory.profile', array('item'=>$this->entity));
    }

    public function calendar()
    {
        return view('maintenance::viewers.inventory.calendar', array('item'=>$this->entity));
    }

    public function stock()
    {
        return view('maintenance::viewers.inventory.stock', array('item'=>$this->entity));
    }

    public function notes()
    {
        return view('maintenance::viewers.inventory.notes', array('item'=>$this->entity));
    }

    public function btnAddNote()
    {
        return view('maintenance::viewers.inventory.buttons.add-note', array('item'=>$this->entity));
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

    public function btnEvents()
    {
        return view('maintenance::viewers.inventory.buttons.events', array('item'=>$this->entity));
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
    
    public function btnEventTag()
    {
        return view('maintenance::viewers.inventory.buttons.event-tag', array(
            'item' => $this->entity,
        ));
    }

    public function btnNoteActions($note)
    {
        return view('maintenance::viewers.inventory.buttons.note-actions', array(
            'item' => $this->entity,
            'note' => $note,
        ));
    }
    
}

