<?php

namespace Stevebauman\Maintenance\Viewers\Inventory;

use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Viewers\BaseViewer;

class InventoryStockViewer extends BaseViewer
{
    /**
     * Returns the stocks profile view.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('maintenance::viewers.inventory.stock.profile', ['stock' => $this->entity]);
    }

    /**
     * Returns the stocks actions button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActions()
    {
        return view('maintenance::viewers.inventory.stock.buttons.actions', ['stock' => $this->entity]);
    }

    /**
     * Returns the stocks edit button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnEdit()
    {
        return view('maintenance::viewers.inventory.stock.buttons.edit', ['stock' => $this->entity]);
    }

    /**
     * Returns the stocks delete button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnDelete()
    {
        return view('maintenance::viewers.inventory.stock.buttons.delete', ['stock' => $this->entity]);
    }

    /**
     * Returns the stocks add to work order button view.
     *
     * @param WorkOrder $workOrder
     *
     * @return \Illuminate\View\View
     */
    public function btnAddForWorkOrder(WorkOrder $workOrder)
    {
        return view('maintenance::viewers.inventory.stock.buttons.add-to-work-order', [
            'workOrder' => $workOrder,
            'stock' => $this->entity,
        ]);
    }

    /**
     * Returns the stocks put back some work order button view.
     *
     * @param WorkOrder $workOrder
     *
     * @return \Illuminate\View\View
     */
    public function btnPutBackSomeForWorkOrder(WorkOrder $workOrder)
    {
        if($this->entity->item) {
            return view('maintenance::viewers.inventory.stock.buttons.put-back-some-work-order', [
                'workOrder' => $workOrder,
                'stock' => $this->entity,
            ]);
        }

        return null;
    }

    /**
     * Returns the stocks put back all work order button view.
     *
     * @param WorkOrder $workOrder
     *
     * @return \Illuminate\View\View
     */
    public function btnPutBackAllForWorkOrder(WorkOrder $workOrder)
    {
        if($this->entity->item) {
            return view('maintenance::viewers.inventory.stock.buttons.put-back-all-work-order', [
                'workOrder' => $workOrder,
                'stock' => $this->entity,
            ]);
        }

        return null;
    }
}
