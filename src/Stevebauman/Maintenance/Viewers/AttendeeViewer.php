<?php

namespace Stevebauman\Maintenance\Viewers;

class AttendeeViewer extends BaseViewer {
    
    public function status()
    {
        return view('maintenance::viewers.event.attendee.status', [
            'attendee' => $this->entity,
        ]);
    }
    
    public function btnActions()
    {
        return view('maintenance::viewers.event.attendee.buttons.actions', [
            'attendee' => $this->entity
        ]);
    }
    
    
}