<?php

namespace Stevebauman\Maintenance\Viewers\Event;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class EventViewer extends BaseViewer {
    
    public function tags()
    {
        return view('maintenance::viewers.event.tags', array(
            'event' => $this->entity
        ));
    }
    
    public function report()
    {
        return view('maintenance::viewers.event.report', array(
            'event' => $this->entity,
        ));
    }
    
}