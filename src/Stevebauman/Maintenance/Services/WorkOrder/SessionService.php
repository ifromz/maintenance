<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Carbon\Carbon;
use Stevebauman\Maintenance\Models\WorkOrderSession;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Services\BaseModelService;

class SessionService extends BaseModelService
{

    public function __construct(WorkOrderSession $session, WorkOrderService $workOrder, SentryService $sentry)
    {
        $this->model = $session;
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
    }

    public function create()
    {

        $this->dbStartTransaction();

        try {

            $workOrder = $this->workOrder->find($this->getInput('work_order_id'));

            $now = Carbon::now()->toDateTimeString();

            /*
             * If this is the first session that is being created on the work order,
             * set the started at property to now
             */
            if ($workOrder->sessions->count() === 0) {

                $update = ['started_at' => $now];

                $this->workOrder->setInput($update)->update($workOrder->id);
            }

            $insert = [
                'user_id' => $this->sentry->getCurrentUser()->id,
                'work_order_id' => $workOrder->id,
                'in' => $now,
            ];

            $record = $this->model->create($insert);

            $this->dbCommitTransaction();

            return $record;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }

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

            $this->dbRollbackTransaction();

            return false;

        } catch (\Exception $e) {

            $this->dbRollbackTransaction();

            return false;
        }
    }
}