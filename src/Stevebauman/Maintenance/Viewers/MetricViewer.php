<?php

namespace Stevebauman\Maintenance\Viewers;

class MetricViewer extends BaseViewer
{
    /**
     * Returns the metrics actions button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActions()
    {
        return view('maintenance::viewers.metric.buttons.actions', ['metric' => $this->entity]);
    }
}
