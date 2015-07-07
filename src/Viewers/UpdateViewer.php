<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Models\WorkRequest;

class UpdateViewer extends BaseViewer
{
    /**
     * Returns the work requests updates view.
     *
     * @param WorkRequest $workRequest
     *
     * @return \Illuminate\View\View
     */
    public function workRequest(WorkRequest $workRequest)
    {
        return view('maintenance::viewers.update.work-request', [
            'workRequest' => $workRequest,
            'update' => $this->entity,
        ]);
    }

    /**
     * Returns the work orders updates view.
     *
     * @param WorkOrder $workOrder
     *
     * @return \Illuminate\View\View
     */
    public function workOrder(WorkOrder $workOrder)
    {
        return view('maintenance::viewers.update.work-order', [
            'workOrder' => $workOrder,
            'update' => $this->entity,
        ]);
    }
}
