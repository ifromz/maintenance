<?php

namespace Stevebauman\Maintenance\Viewers\WorkOrder;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class SessionViewer extends BaseViewer
{
    public function totalHours()
    {
        return view('maintenance::viewers.work-order.session.total-hours', [
            'totalHours' => $this->entity->total_hours,
        ]);
    }
}
