<?php

namespace Stevebauman\Maintenance\Models;

use Stevebauman\Maintenance\Models\BaseModel;

class CalendarEventReport extends BaseModel {
    
    protected $table = 'calendar_event_reports';
    
    public function event()
    {
        return $this->hasOne('Stevebauman\Maintenance\Models\CalendarEvent', 'id', 'event_id');
    }
    
}