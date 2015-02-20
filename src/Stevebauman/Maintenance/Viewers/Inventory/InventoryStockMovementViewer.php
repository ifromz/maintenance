<?php

namespace Stevebauman\Maintenance\Viewers\Inventory;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class InventoryStockMovementViewer extends BaseViewer {

    public function profile()
    {
        return view('maintenance::viewers.inventory.stock.movement.profile', array('movement'=>$this->entity));
    }

    public function btnRollback($item, $stock)
    {
        return view('maintenance::viewers.inventory.stock.movement.buttons.rollback', array(
            'item' => $item,
            'stock' => $stock,
            'movement'=>$this->entity
        ));
    }

    public function btnActions($item, $stock)
    {
        return view('maintenance::viewers.inventory.stock.movement.buttons.actions', array(
            'item' => $item,
            'stock' => $stock,
            'movement'=>$this->entity
        ));
    }

}