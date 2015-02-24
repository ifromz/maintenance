<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Carbon\Carbon;
use Stevebauman\Maintenance\Models\WorkOrderReport;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class ReportService
 * @package Stevebauman\Maintenance\Services\WorkOrder
 */
class ReportService extends BaseModelService
{

    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param WorkOrderReport $report
     * @param WorkOrderService $workOrder
     * @param SentryService $sentry
     */
    public function __construct(WorkOrderReport $report, WorkOrderService $workOrder, SentryService $sentry)
    {
        $this->model = $report;
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
    }

    /**
     * Creates a work order report
     *
     * @return bool|static
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {

            /*
             * Find the work order
             */
            $workOrder = $this->workOrder->find($this->getInput('work_order_id'));

            /*
             * Set the insert data for the work order report
             */
            $insert = array(
                'user_id' => $this->sentry->getCurrentUserId(),
                'work_order_id' => $workOrder->id,
                'description' => $this->getInput('description', NULL, true),
            );

            /*
             * Create the work order report
             */
            $record = $this->model->create($insert);

            /*
             * Get the current time to update the work order
             */
            $now = Carbon::now()->toDateTimeString();

            /*
             * Update the work order with the completed at time since a work order
             * would be complete once a report has been filled out. If a started_at time exists
             * then we'll throw NULL inside so it isn't updated, otherwise we'll throw in today's time
             */
            $update = array(
                'started_at' => ($workOrder->started_at ? NULL : $now),
                'completed_at' => $now
            );

            /*
             * Update the work order
             */
            $workOrder = $this->workOrder->setInput($update)->update($workOrder->id);

            /*
             * Close any open sessions that may be open on the work order
             */
            $workOrder->closeSessions();

            /*
             * Fire the work order report created event
             */
            $this->fireEvent('maintenance.work-orders.reports.created', array(
                'report' => $record
            ));

            /*
             * Commit the database transaction
             */
            $this->dbCommitTransaction();

            /*
             * Return the created report
             */
            return $record;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

}