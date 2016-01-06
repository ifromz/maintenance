<?php

namespace App\Http\Controllers\WorkOrder;

use App\Processors\WorkOrder\WorkOrderPartProcessor;
use App\Http\Controllers\Controller;

class WorkOrderPartController extends Controller
{
    /**
     * @var WorkOrderPartProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param WorkOrderPartProcessor $processor
     */
    public function __construct(WorkOrderPartProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all the work orders parts.
     *
     * @param int|string $workOrderId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId)
    {
        return $this->processor->index($workOrderId);
    }
}
