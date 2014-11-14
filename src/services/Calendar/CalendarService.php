<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Calendar;
use Stevebauman\Maintenance\Services\AbstractModelService;

class CalendarService extends AbstractModelService {
    
    public function __construct(Calendar $calendar)
    {
        $this->model = $calendar;
    }
    
    
    
}