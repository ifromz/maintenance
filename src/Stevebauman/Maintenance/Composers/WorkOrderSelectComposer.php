<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;

/**
 * Class WorkOrderSelectComposer
 * @package Stevebauman\Maintenance\Composers
 */
class WorkOrderSelectComposer
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
     * @param $view
     * @return mixed
     */
    public function compose($view)
    {
        $allWorkOrders = $this->workOrder->get()->lists('subject', 'id');

        return $view->with('allWorkOrders', $allWorkOrders);
    }

}
