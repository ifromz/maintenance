<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Models\WorkRequest;

/**
 * Class WorkRequest
 * @package Stevebauman\Maintenance\Services
 */
class WorkRequestService extends BaseModelService {

    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @param WorkRequest $workRequest
     * @param WorkOrderService $workOrder
     * @param SentryService $sentry
     */
    public function __construct(WorkRequest $workRequest, WorkOrderService $workOrder, SentryService $sentry)
    {
        $this->model = $workRequest;
        $this->workOrder = $workOrder;
        $this->sentry = $sentry;
    }

    /**
     * Creates a work request
     *
     * @return bool|mixed
     */
    public function create()
    {
        $this->dbStartTransaction();

        try
        {
            $workRequest = new $this->model;
            $workRequest->user_id = $this->sentry->getCurrentUserId();
            $workRequest->subject = $this->getInput('subject', NULL, true);
            $workRequest->best_time = $this->getInput('best_time', NULL, true);
            $workRequest->description = $this->getInput('description', NULL, true);

            if($workRequest->save())
            {
                $workOrder = $this->workOrder->createFromWorkRequest($workRequest);

                if($workOrder)
                {
                    $this->dbCommitTransaction();

                    return $workRequest;
                }
            }

        } catch(\Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Updates a work request
     *
     * @param int|string $id
     * @return bool|mixed
     */
    public function update($id)
    {
        $this->dbStartTransaction();

        $workRequest = $this->find($id);

        try
        {
            $workRequest->subject = $this->getInput('subject', $workRequest->subject, true);
            $workRequest->best_time = $this->getInput('best_time', $workRequest->best_time, true);
            $workRequest->description = $this->getInput('description', $workRequest->description, true);

            if($workRequest->save())
            {
                $this->dbCommitTransaction();

                return $workRequest;
            }
        } catch(\Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }

    /**
     * Attaches an update to the work request pivot table
     *
     * @param $workRequest
     * @param $update
     * @return bool
     */
    public function saveUpdate($workRequest, $update)
    {
        $this->dbStartTransaction();

        try
        {
            if ($workRequest->updates()->save($update))
            {
                $this->fireEvent('maintenance.work-requests.updates.created', array(
                    'workRequest' => $workRequest,
                    'update' => $update
                ));

                $this->dbCommitTransaction();

                return true;
            }

        } catch (\Exception $e)
        {
            $this->dbRollbackTransaction();
        }

        return false;
    }

}