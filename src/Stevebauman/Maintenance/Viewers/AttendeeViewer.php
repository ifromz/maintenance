<?php

namespace Stevebauman\Maintenance\Viewers;

class AttendeeViewer extends BaseViewer {
    
    public function status()
    {
        return view('maintenance::viewers.event.attendee.status', array(
            'attendee' => $this->entity,
        ));
    }
    
    public function btnActions()
    {
        return view('maintenance::viewers.event.attendee.buttons.actions', array(
            'attendee' => $this->entity
        ));
    }
    
    
}