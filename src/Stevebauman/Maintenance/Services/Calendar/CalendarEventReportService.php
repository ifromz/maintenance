<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\CalendarEventReport;
use Stevebauman\Maintenance\Services\AbstractModelService;

class CalendarEventReportService extends AbstractModelService {
    
    public function __construct(CalendarEventReport $calendarEventReport)
    {
        $this->model = $calendarEventReport;
    }
    
    
    
}