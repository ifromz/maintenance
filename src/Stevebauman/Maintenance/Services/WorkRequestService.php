<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Models\Update;
use Stevebauman\Maintenance\Models\WorkRequest;

/**
 * Class WorkRequest
 * @package Stevebauman\Maintenance\Services
 */
class WorkRequestService extends BaseModelService
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
     * Constructor.
     *
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
     * Retrieves all the work requests paginated, with search filters.
     *
     * @param bool $archived
     *
     * @return \Illuminate\Support\Collection
     */
    public function getByPageWithFilter($archived = null)
    {
        return $this->model
            ->with(['user'])
            ->id($this->getInput('id'))
            ->sort($this->getInput('field'), $this->getInput('sort'))
            ->archived($archived)
            ->paginate(25);
    }

    /**
     * Creates a work request
     *
     * @return bool|WorkRequest
     */
    public function create()
    {
        $this->dbStartTransaction();

        try
        {
            $workRequest = new $this->model;
            $workRequest->user_id = $this->sentry->getCurrentUserId();
            $workRequest->subject = $this->getInput('subject', null, true);
            $workRequest->best_time = $this->getInput('best_time', null, true);
            $workRequest->description = $this->getInput('description', null, true);

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
     *
     * @return bool|WorkRequest
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
     * @param WorkRequest $workRequest
     * @param $update
     *
     * @return bool
     */
    public function saveUpdate(WorkRequest $workRequest, Update $update)
    {
        $this->dbStartTransaction();

        try
        {
            if ($workRequest->updates()->save($update))
            {
                $this->fireEvent('maintenance.work-requests.updates.created', [
                    'workRequest' => $workRequest,
                    'update' => $update
                ]);

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
