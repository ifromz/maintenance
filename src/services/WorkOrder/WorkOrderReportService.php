<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\WorkOrderReport;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\AbstractModelService;

class WorkOrderReportService extends AbstractModelService {
    
    public function __construct(WorkOrderReport $report, SentryService $sentry){
        $this->model = $report;
        $this->sentry = $sentry;
    }
    
    public function create(){
        
        $insert = array(
            'user_id' => $this->sentry->getCurrentUserId(),
            'work_order_id' => $this->getInput('work_order_id'),
            'description' => $this->input('description', NULL, true),
        );
        
        if($record = $this->model->create($insert)){
            return $record;
        } return false;
    }
    
}