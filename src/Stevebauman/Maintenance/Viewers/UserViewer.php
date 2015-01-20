<?php

namespace Stevebauman\Maintenance\Viewers;

/**
 * Class UserViewer
 * @package Stevebauman\Maintenance\Viewers
 */
class UserViewer extends BaseViewer {

    public function btnActions()
    {
        return view('maintenance::viewers.user.buttons.actions', array(
            'user' => $this->entity,
        ));
    }

}