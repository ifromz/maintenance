<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkRequest;

use Stevebauman\Maintenance\Validators\UpdateValidator;
use Stevebauman\Maintenance\Services\WorkRequestService;
use Stevebauman\Maintenance\Services\UpdateService;
use Stevebauman\Maintenance\Http\Controllers\Controller;

/**
 * Class UpdateController.
 */
class UpdateController extends Controller
{
    /**
     * @var UpdateService
     */
    protected $update;

    /**
     * @var WorkRequestService
     */
    protected $workRequest;

    /**
     * @var UpdateValidator
     */
    protected $updateValidator;

    /**
     * @param UpdateService      $update
     * @param WorkRequestService $workRequest
     * @param UpdateValidator    $updateValidator
     */
    public function __construct(UpdateService $update, WorkRequestService $workRequest, UpdateValidator $updateValidator)
    {
        $this->update = $update;
        $this->workRequest = $workRequest;
        $this->updateValidator = $updateValidator;
    }

    /**
     * Creates a new work order customer update.
     *
     * @param int $workRequestId
     *
     * @return mixed
     */
    public function store($workRequestId)
    {
        if ($this->updateValidator->passes()) {
            $workRequest = $this->workRequest->find($workRequestId);

            $update = $this->update->setInput($this->inputAll())->create();

            $this->workRequest->saveUpdate($workRequest, $update);

            $this->message = 'Successfully added update';
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.work-orders.show', [$workRequest->id]);
        } else {
            $this->errors = $this->updateValidator->getErrors();
            $this->redirect = routeBack('maintenance.work-orders.show', [$workRequestId]);
        }

        return $this->response();
    }

    /**
     * Processes deleting a work order update.
     *
     * @param $workRequestId
     * @param $updateId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($workRequestId, $updateId)
    {
        $workRequest = $this->workRequest->find($workRequestId);

        if ($this->update->destroy($updateId)) {
            $this->message = 'Successfully deleted update';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.show', [$workRequest->id, '#tab_updates']);
        } else {
            $this->message = 'There was an error trying to delete this update. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', [$workRequest->id, '#tab_updates']);
        }

        return $this->response();
    }
}
