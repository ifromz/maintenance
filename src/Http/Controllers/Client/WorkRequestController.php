<?php

namespace Http\Controllers\Client;

use Stevebauman\Maintenance\Http\Requests\WorkRequest\Request as WorkRequest;
use Stevebauman\Maintenance\Repositories\Client\WorkRequestRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class WorkRequestController extends BaseController
{
    /**
     * @var WorkRequestRepository
     */
    protected $workRequest;

    /**
     * Constructor.
     *
     * @param WorkRequestRepository $workRequest
     */
    public function __construct(WorkRequestRepository $workRequest)
    {
        $this->workRequest = $workRequest;
    }

    public function index()
    {
        
    }

    public function create()
    {

    }

    public function store(WorkRequest $request)
    {
        $workRequest = $this->workRequest->create($request);

        if($workRequest) {

        } else {

        }
    }

    public function edit($id)
    {

    }

    public function update(WorkRequest $request, $id)
    {
        $workRequest = $this->workRequest->update($request, $id);

        if($workRequest) {

        } else {

        }
    }

    public function destroy($id)
    {
        if($this->workRequest->delete($id)) {

        } else {

        }
    }
}
