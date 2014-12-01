<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\CalendarEventReport;
use Stevebauman\Maintenance\Services\BaseModelService;

class CalendarEventReportService extends BaseModelService {
    
    public function __construct(CalendarEventReport $calendarEventReport)
    {
        $this->model = $calendarEventReport;
    }
    
    
    
}