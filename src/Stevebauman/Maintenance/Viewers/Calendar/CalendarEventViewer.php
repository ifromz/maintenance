<?php

namespace Stevebauman\Maintenance\Viewers;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class CalendarEventViewer extends BaseViewer {
    
    public function btnActionsForAssetCalendar($asset, $calendar)
    {
        return view('maintenance::viewers.calendar.event.buttons.actions-asset-calendar', array(
            'asset' => $asset, 
            'calendar' => $calendar,
            'event' => $this->entity,
        ));
    }
    
}