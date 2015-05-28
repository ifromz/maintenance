<?php

namespace Stevebauman\Maintenance\Controllers\WorkRequest;

use Stevebauman\Maintenance\Validators\WorkRequestValidator;
use Stevebauman\Maintenance\Services\WorkRequestService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class WorkRequest.
 */
class WorkRequestController extends BaseController
{
    /**
     * @var WorkRequestService
     */
    protected $workRequest;

    /**
     * @var WorkRequestValidator
     */
    protected $workRequestValidator;

    /**
     * @param WorkRequestService   $workRequest
     * @param WorkRequestValidator $workRequestValidator
     */
    public function __construct(WorkRequestService $workRequest, WorkRequestValidator $workRequestValidator)
    {
        $this->workRequest = $workRequest;
        $this->workRequestValidator = $workRequestValidator;
    }

    /**
     * Displays all work requests.
     *
     * @return mixed
     */
    public function index()
    {
        $workRequests = $this->workRequest
            ->setInput($this->inputAll())
            ->getByPageWithFilter();

        return view('maintenance::work-requests.index', [
            'title' => 'Work Requests',
            'workRequests' => $workRequests,
        ]);
    }

    /**
     * Displays the form to create a work request.
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::work-requests.create', [
            'title' => 'Create a Work Request',
        ]);
    }

    /**
     * Processes creating a work request.
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store()
    {
        if ($this->workRequestValidator->passes()) {
            $workRequest = $this->workRequest->setInput($this->inputAll())->create();

            if ($workRequest) {
                $this->message = 'Successfully created work request.';
                $this->messageType = 'success';
            } else {
                $this->message = 'There was an issue trying to create a work request. Please try again';
                $this->messageType = 'danger';
            }
        } else {
            $this->errors = $this->workRequestValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Displays a work request by the specified ID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $workRequest = $this->workRequest->find($id);

        return view('maintenance::work-requests.show', [
            'title' => 'Viewing Work Request: '.$workRequest->subject,
            'workRequest' => $workRequest,
        ]);
    }

    public function edit($id)
    {
    }

    public function update($id)
    {
    }

    /**
     * Deletes the specified work request.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->workRequest->destroy($id)) {
            $this->message = 'Successfully deleted work request.';
            $this->messageType = 'success';
            $this->redirect = routeBack('maintenance.work-requests.index');
        } else {
            $this->message = 'There was an issue deleting this work request. Please try again later.';
            $this->messageType = 'danger';
            $this->redirect = routeBack('maintenance.work-requests.show', [$id]);
        }

        return $this->response();
    }
}
