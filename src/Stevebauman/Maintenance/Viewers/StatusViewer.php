<?php

namespace Stevebauman\Maintenance\Viewers;

class StatusViewer extends BaseViewer
{
    /**
     * Returns the status' actions button view.
     *
     * @return \Illuminate\View\View
     */
    public function btnActions()
    {
        return view('maintenance::viewers.status.buttons.actions', ['status' => $this->entity]);
    }
}
