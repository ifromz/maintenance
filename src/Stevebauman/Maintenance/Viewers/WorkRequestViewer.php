<?php

namespace Stevebauman\Maintenance\Viewers;

/**
 * Class WorkRequest
 * @package Stevebauman\Maintenance\Viewers
 */
class WorkRequestViewer extends BaseViewer {

    public function profile()
    {
        return view('maintenance::viewers.work-request.profile', array('workRequest'=>$this->entity));
    }

    public function btnActions()
    {
        return view('maintenance::viewers.work-request.buttons.actions', array('workRequest'=>$this->entity));
    }

}