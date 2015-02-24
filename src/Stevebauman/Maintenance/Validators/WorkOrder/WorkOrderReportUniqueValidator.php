<?php namespace Stevebauman\Maintenance\Validators;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Illuminate\Support\Facades\Route;

/**
 * Class WorkOrderReportUniqueValidator
 * @package Stevebauman\Maintenance\Validators
 */
class WorkOrderReportUniqueValidator
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
     * @param $attribute
     * @param $location_id
     * @param $parameters
     * @return bool
     */
    public function validateUniqueReport($attribute, $location_id, $parameters)
    {
        $work_order_id = Route::getCurrentRoute()->getParameter('work_orders');
         
        if($workOrder = $this->workOrder->find($work_order_id))
        {
            if($workOrder->report) return false;

            return true;
        } 
        
        return false;
        
     }
}