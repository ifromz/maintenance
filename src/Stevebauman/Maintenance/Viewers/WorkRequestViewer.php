<?php

namespace Stevebauman\Maintenance\Viewers;

/**
 * Class WorkRequest.
 */
class WorkRequestViewer extends BaseViewer
{
    public function profile()
    {
        return view('maintenance::viewers.work-request.profile', ['workRequest' => $this->entity]);
    }

    public function updates()
    {
        return view('maintenance::viewers.work-request.updates', ['workRequest' => $this->entity]);
    }

    public function btnActions()
    {
        return view('maintenance::viewers.work-request.buttons.actions', ['workRequest' => $this->entity]);
    }
}
