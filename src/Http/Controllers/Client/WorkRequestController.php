<?php

namespace Stevebauman\Maintenance\Http\Controllers\Client;

use Stevebauman\Maintenance\Services\WorkRequestService;
use Stevebauman\Maintenance\Http\Controllers\Controller;

/**
 * Class WorkRequestController.
 */
class WorkRequestController extends Controller
{
    /**
     * @var WorkRequestService
     */
    protected $workRequest;

    /**
     * @param WorkRequestService $workRequest
     */
    public function __construct(WorkRequestService $workRequest)
    {
        $this->workRequest = $workRequest;
    }

    public function index()
    {
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function edit($id)
    {
    }

    public function update($id)
    {
    }
}
