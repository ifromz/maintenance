<?php

namespace Stevebauman\Maintenance\Validators\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Illuminate\Support\Facades\Route;

class ReportUniqueValidator
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @param WorkOrderService $workOrder
     */
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Validates that work order only contains one report.
     *
     * @param string     $attribute
     * @param int|string $locationId
     * @param $parameters
     *
     * @return bool
     */
    public function validateUniqueReport($attribute, $locationId, $parameters)
    {
        $workOrderId = Route::getCurrentRoute()->getParameter('work_orders');

        if ($workOrder = $this->workOrder->find($workOrderId)) {
            if ($workOrder->report) {
                return false;
            }

            return true;
        }

        return false;
    }
}
