<?php

namespace App\Composers;

use App\Services\WorkOrder\WorkOrderService;
use Illuminate\View\View;

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
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $allWorkOrders = $this->workOrder->get()->lists('subject', 'id');

        return $view->with('allWorkOrders', $allWorkOrders);
    }
}
