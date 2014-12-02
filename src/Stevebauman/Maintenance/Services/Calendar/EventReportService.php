<?php

namespace Stevebauman\Maintenance\Services\Calendar;

use Stevebauman\Maintenance\Models\CalendarEventReport;
use Stevebauman\Maintenance\Services\BaseModelService;

class EventReportService extends BaseModelService {
    
    public function __construct(CalendarEventReport $calendarEventReport)
    {
        $this->model = $calendarEventReport;
    }
    
    
    
}