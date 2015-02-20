<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\WorkRequestValidator;
use Stevebauman\Maintenance\Services\WorkRequestService;

/**
 * Class WorkRequest
 * @package Stevebauman\Maintenance\Controllers\WorkRequest
 */
class WorkRequestController extends BaseController {

    /**
     * @var WorkRequestService
     */
    protected $workRequest;

    /**
     * @var WorkRequestValidator
     */
    protected $workRequestValidator;

    /**
     * @param WorkRequestService $workRequest
     * @param WorkRequestValidator $workRequestValidator
     */
    public function __construct(WorkRequestService $workRequest, WorkRequestValidator $workRequestValidator)
    {
        $this->workRequest = $workRequest;
        $this->workRequestValidator = $workRequestValidator;
    }

    public function index()
    {
        $workRequests = $this->workRequest->get();

        return view('maintenance::work-requests.index', array(
            'title' => 'Work Requests',
            'workRequests' => $workRequests,
        ));
    }

    public function create()
    {
        return view('maintenance::work-requests.create', array(
            'title' => 'Create a Work Request',
        ));
    }

    public function store()
    {
        if($this->workRequestValidator->passes()) {

            $workRequest = $this->workRequest->setInput($this->inputAll())->create();

            if($workRequest) {

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

    public function show($id)
    {
        $workRequest = $this->workRequest->find($id);

        return view('maintenance::work-requests.show', array(
            'title' => 'Viewing Work Request: '.$workRequest->subject,
            'workRequest' => $workRequest,
        ));
    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

    public function destroy($id)
    {

    }

}