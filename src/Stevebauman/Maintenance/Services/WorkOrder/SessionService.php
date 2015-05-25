<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Carbon\Carbon;
use Stevebauman\Maintenance\Models\WorkOrderSession;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

/**
 * Class SessionService.
 */
class SessionService extends BaseModelService
{
    /**
     * @var WorkOrderSession
     */
    protected $model;

    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param WorkOrderSession $session
     * @param WorkOrderService $workOrder
     * @param SentryService    $sentry
     */
    public function __construct(WorkOrderSession $session, WorkOrderService $workOrder, SentryService $sentry)
    {
        $this->model = $session;
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
    }

    /**
     * Creates a new work order session.
     *
     * @return bool|WorkOrderSession
     */
    public function create()
    {
        $this->dbStartTransaction();

        try {
            $workOrder = $this->workOrder->find($this->getInput('work_order_id'));

            $now = Carbon::now()->toDateTimeString();

            /*
             * If this is the first session that is being created on
             * the work order, set the started at property to now
             */
            if ($workOrder->sessions->count() === 0) {
                $update = ['started_at' => $now];

                $this->workOrder->setInput($update)->update($workOrder->id);
            }

            $insert = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'work_order_id' => $workOrder->id,
                'in' => $now,
            ];

            $record = $this->model->create($insert);

            if ($record) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Updates the specified work order session.
     *
     * @param int|string $id
     *
     * @return bool|WorkOrderSession
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        try {
            $record = $this->model->find($id);

            $insert = [
                'out' => Carbon::now()->toDateTimeString(),
            ];

            if ($record->update($insert)) {
                $this->dbCommitTransaction();

                return $record;
            }
        } catch (\Exception $e) {
            $this->dbRollbackTransaction();
        }

        return false;
    }
}
