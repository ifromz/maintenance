<?php

namespace App\Http\Controllers\WorkOrder;

use App\Repositories\WorkRequest\Repository as WorkOrderRepository;

class AssetController
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     */
    public function __construct(WorkOrderRepository $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Displays all assets attached to the specified work order.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $workOrder = $this->workOrder->model()->findOrFail($id);

        return view('work-orders.assets.index', compact('workOrder'));
    }
}
