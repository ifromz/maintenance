<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Carbon\Carbon;
use Stevebauman\Maintenance\Models\WorkOrderReport;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

class ReportService extends BaseModelService
{

    public function __construct(WorkOrderReport $report, WorkOrderService $workOrder, SentryService $sentry)
    {
        $this->model = $report;
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
    }

    public function create()
    {

        $this->dbStartTransaction();

        try {

            $workOrder = $this->workOrder->find($this->getInput('work_order_id'));

            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'work_order_id' => $workOrder->id,
                'description' => $this->getInput('description', NULL, true),
            );

            $record = $this->model->create($insert);

            /*
             * Update the work order with the completed at time since a work order
             * would be complete once a report has been filled out
             */
            $update = array(
                'completed_at' => Carbon::now()->toDateTimeString()
            );

            $this->workOrder->setInput($update)->update($workOrder->id);

            $this->fireEvent('maintenance.work-orders.reports.created', array(
                'report' => $record
            ));

            $this->dbCommitTransaction();

            return $record;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

}