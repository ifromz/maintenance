<?php

namespace Stevebauman\Maintenance\Viewers;

class UpdateViewer extends BaseViewer
{
    public function workRequest($workRequest)
    {
        return view('maintenance::viewers.update.work-request', [
            'workRequest' => $workRequest,
            'update' => $this->entity,
        ]);
    }

    public function workOrder($workOrder)
    {
        return view('maintenance::viewers.update.work-order', [
            'workOrder' => $workOrder,
            'update' => $this->entity,
        ]);
    }
}
