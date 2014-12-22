<?php

namespace Stevebauman\Maintenance\Controllers\Event;

use Stevebauman\Maintenance\Services\EventReportService;
use Stevebauman\Maintenance\Controllers\BaseController;

class ReportController extends BaseController {
    
    public function __construct(EventReportService $report)
    {
        $this->report = $report;
    }
    
    public function store($eventable_id, $api_id)
    {
        
    }
    
    public function edit($eventable_id, $api_id, $report_id)
    {
        
    }
    
    public function update($eventable_id, $api_id, $report_id)
    {
        
    }
    
    public function destroy($eventable_id, $api_id, $report_id)
    {
        
    }
    
}