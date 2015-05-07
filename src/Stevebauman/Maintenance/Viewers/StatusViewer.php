<?php

namespace Stevebauman\Maintenance\Viewers;

class StatusViewer extends BaseViewer
{
    public function btnActions()
    {
        return view('maintenance::viewers.status.buttons.actions', ['status' => $this->entity]);
    }
}
