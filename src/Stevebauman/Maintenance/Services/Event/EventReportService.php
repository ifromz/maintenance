<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\EventReport;
use Stevebauman\Maintenance\Services\BaseModelService;

class EventReportService extends BaseModelService {
    
    public function __construct(EventReport $report)
    {
        $this->model = $report;
    }
    
    public function create()
    {
        
    }
    
}