<?php

namespace Stevebauman\Maintenance\Repositories\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\WorkOrder\Request;
use Stevebauman\Maintenance\Services\ConfigService;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Models\WorkRequest;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class Repository extends BaseRepository
{
    /**
     * @var StatusRepository
     */
    protected $status;

    /**
     * @var PriorityRepository
     */
    protected $priority;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param StatusRepository   $status
     * @param PriorityRepository $priority
     * @param SentryService      $sentry
     * @param ConfigService      $config
     */
    public function __construct(
        StatusRepository $status,
        PriorityRepository $priority,
        SentryService $sentry,
        ConfigService $config
    ) {
        $this->status = $status;
        $this->priority = $priority;
        $this->sentry = $sentry;
        $this->config = $config;
    }

    /**
     * @return WorkOrder
     */
    public function model()
    {
        return new WorkOrder();
    }

    /**
     * Finds the last current users session record.
     *
     * @param int|string $workOrderId
     *
     * @return null|\Stevebauman\Maintenance\Models\WorkOrderSession
     */
    public function findLastUserSession($workOrderId)
    {
        $workOrder = $this->find($workOrderId);

        return $workOrder
            ->sessions()
            ->where('user_id', $this->sentry->getCurrentUserId())
            ->first();
    }

    /**
     * Creates a new work order.
     *
     * @param Request $request
     *
     * @return bool|WorkOrder
     */
    public function create(Request $request)
    {
        $workOrder = $this->model();

        $workOrder->user_id = $this->sentry->getCurrentUserId();
        $workOrder->category_id = $request->input('category_id');
        $workOrder->location_id = $request->input('location_id');
        $workOrder->status_id = $request->input('status_id');
        $workOrder->priority_id = $request->input('priority_id');
        $workOrder->subject = $request->input('subject');
        $workOrder->description = $request->clean($request->input('description'));
        $workOrder->started_at = $request->input('started_at');
        $workOrder->completed_at = $request->input('completed_at');

        if($workOrder->save()) {

            $assets = $request->input('assets');

            if(count($assets) > 0) {
                $workOrder->assets()->attach($assets);
            }

            return $workOrder;
        }

        return false;
    }

    /**
     * Creates a new work order from a work request.
     *
     * @param WorkRequest $workRequest
     *
     * @return bool|WorkOrder
     */
    public function createFromWorkRequest(WorkRequest $workRequest)
    {
        /*
         * We'll make sure the work request doesn't already have a
         * work order attached to it before we try and create it
         */
        if (!$workRequest->workOrder) {
            $priority = $this->priority->createDefaultRequested();

            $status = $this->status->createDefaultRequested();

            $workOrder = $this->model();

            $workOrder->status_id = $status->id;
            $workOrder->priority_id = $priority->id;
            $workOrder->request_id = $workRequest->id;
            $workOrder->user_id = $workRequest->user_id;
            $workOrder->subject = $workRequest->subject;
            $workOrder->description = $workRequest->description;

            if ($workOrder->save()) {
                return $workOrder;
            }
        }

        return false;
    }

    /**
     * Updates a work order.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return bool|WorkOrder
     */
    public function update(Request $request, $id)
    {
        $workOrder = $this->model()->findOrFail($id);

        $workOrder->category_id = $request->input('category_id', $workOrder->category_id);
        $workOrder->location_id = $request->input('location_id', $workOrder->location_id);
        $workOrder->status_id = $request->input('status_id', $workOrder->status_id);
        $workOrder->priority_id = $request->input('priority_id', $workOrder->priority_id);
        $workOrder->subject = $request->input('subject', $workOrder->subject);
        $workOrder->description = $request->clean($request->input('description', $workOrder->description));
        $workOrder->started_at = $request->input('started_at', $workOrder->started_at);
        $workOrder->completed_at = $request->input('completed_at', $workOrder->completed_at);

        if($workOrder->save()) {

            $assets = $request->input('assets', $workOrder->assets);

            if(count($assets) > 0) {
                $workOrder->assets()->attach($assets);
            }

            return $workOrder;
        }

        return false;
    }

    /**
     * Retrieves all of the current users inventory items.
     *
     * @param array    $columns
     * @param array    $settings
     * @param \Closure $transformer
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridAssigned(array $columns = [], array $settings = [], $transformer = null)
    {
        $model = $this->model()->assignedUser($this->sentry->getCurrentUserId());

        return $this->newGrid($model, $columns, $settings, $transformer);
    }
}
