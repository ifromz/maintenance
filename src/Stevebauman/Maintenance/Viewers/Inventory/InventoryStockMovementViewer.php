<?php

namespace Stevebauman\Maintenance\Viewers\Inventory;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class InventoryStockMovementViewer extends BaseViewer {

    public function btnRollback()
    {
        return view('viewers.inventory.stock.movement.buttons.rollback', array('movevement'=>$this->entity));
    }

}