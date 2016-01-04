<?php

namespace App\Repositories\Client;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\WorkRequest\Request as WorkRequest;
use App\Repositories\CurrentUserRepository;
use App\Repositories\Repository as BaseRepository;
use App\Repositories\WorkOrder\Repository as WorkOrderRepository;
use App\Services\ConfigService;

class WorkRequestRepository extends BaseRepository
{
    /**
     * @var CurrentUserRepository
     */
    protected $currentUser;

    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * @param CurrentUserRepository $currentUser
     * @param WorkOrderRepository   $workOrder
     * @param ConfigService         $config
     */
    public function __construct(CurrentUserRepository $currentUser, WorkOrderRepository $workOrder, ConfigService $config)
    {
        $this->currentUser = $currentUser;
        $this->workOrder = $workOrder;
        $this->config = $config;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function model()
    {
        return $this->currentUser->model()->workRequests();
    }

    /**
     * Finds a users work request.
     *
     * @param int|string $id
     *
     * @return \App\Models\WorkRequest
     */
    public function find($id)
    {
        $with = [
            'workOrder',
            'updates',
        ];

        $record = $this->model()->with($with)->find($id);

        if ($record) {
            return $record;
        }

        throw new ModelNotFoundException();
    }

    /**
     * Creates a user work request.
     *
     * @param WorkRequest $request
     *
     * @return bool|\App\Models\WorkRequest
     */
    public function create(WorkRequest $request)
    {
        $attributes = [
            'subject'     => $request->input('subject'),
            'description' => $request->clean($request->input('description')),
            'best_time'   => $request->input('best_time'),
        ];

        $workRequest = $this->model()->create($attributes);

        if ($workRequest) {
            $autoGenerate = $this->config->setPrefix('maintenance')->get('rules.work-orders.auto_generate_from_request', true);

            if ($autoGenerate) {
                $this->workOrder->createFromWorkRequest($workRequest);
            }

            return $workRequest;
        }

        return false;
    }

    /**
     * Updates a users work request.
     *
     * @param WorkRequest $request
     * @param int|string  $id
     *
     * @return bool|\App\Models\WorkRequest
     */
    public function update(WorkRequest $request, $id)
    {
        $workRequest = $this->model()->findOrFail($id);

        $attributes = [
            'subject'     => $request->input('subject', $workRequest->subject),
            'description' => $request->clean($request->input('description', $workRequest->description)),
            'best_time'   => $request->input('best_time', $workRequest->best_time),
        ];

        if ($workRequest->update($attributes)) {
            return $workRequest;
        }

        return false;
    }

    /**
     * Deletes a work request.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function delete($id)
    {
        $workRequest = $this->model()->find($id);

        if ($workRequest) {
            $workRequest->delete();

            return true;
        }

        return false;
    }
}
