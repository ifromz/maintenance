<?php

namespace Stevebauman\Maintenance\Viewers\WorkOrder;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class SessionViewer extends BaseViewer
{
    /**
     * Displays the total session hours.
     *
     * @return \Illuminate\View\View
     */
    public function totalHours()
    {
        return view('maintenance::viewers.work-order.session.total-hours', [
            'totalHours' => $this->entity->total_hours,
        ]);
    }

    /**
     * Displays the session out label.
     *
     * @return \Illuminate\View\View
     */
    public function lblOut()
    {
        return view('maintenance::viewers.work-order.session.labels.out', ['out' => $this->entity->out])->render();
    }
}
