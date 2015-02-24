<?php

namespace Stevebauman\Maintenance\Viewers\Inventory;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class InventoryStockViewer extends BaseViewer {

    public function profile()
    {
        return view('maintenance::viewers.inventory.stock.profile', array('stock'=>$this->entity));
    }

    public function btnActions()
    {
        return view('maintenance::viewers.inventory.stock.buttons.actions', array('stock'=>$this->entity));
    }

    public function btnEdit()
    {
        return view('maintenance::viewers.inventory.stock.buttons.edit', array('stock'=>$this->entity));
    }

    public function btnDelete()
    {
        return view('maintenance::viewers.inventory.stock.buttons.delete', array('stock'=>$this->entity));
    }
    
    public function btnAddForWorkOrder($workOrder)
    {
        return view('maintenance::viewers.inventory.stock.buttons.add-to-work-order', array(
            'workOrder' => $workOrder,
            'stock' => $this->entity,
        ));
    }

    public function btnPutBackSomeForWorkOrder($workOrder)
    {
        return view('maintenance::viewers.inventory.stock.buttons.put-back-some-work-order', array(
            'workOrder' => $workOrder,
            'stock' => $this->entity,
        ));
    }

    public function btnPutBackAllForWorkOrder($workOrder)
    {
        return view('maintenance::viewers.inventory.stock.buttons.put-back-all-work-order', array(
            'workOrder' => $workOrder,
            'stock' => $this->entity,
        ));
    }
    
}