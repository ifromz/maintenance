<?php 

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Stevebauman\Maintenance\Models\WorkOrderReport;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

class ReportService extends BaseModelService {
    
    public function __construct(WorkOrderReport $report, SentryService $sentry){
        $this->model = $report;
        $this->sentry = $sentry;
    }
    
    public function create()
    {
        
        $this->dbStartTransaction();
        
        try {
            
            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'work_order_id' => $this->getInput('work_order_id'),
                'description' => $this->getInput('description', NULL, true),
            );

            $record = $this->model->create($insert);

            $this->fireEvent('maintenance.work-orders.reports.created', array(
                'report'=>$record
            ));

            $this->dbCommitTransaction();
            
            return $record;
        
        } catch (Exception $e) {
            
            $this->dbRollbackTransaction();
            
            return false;
        }
    }
    
}