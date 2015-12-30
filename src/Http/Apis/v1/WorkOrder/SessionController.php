<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;

class SessionController extends BaseController
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     */
    public function __construct(WorkOrderRepository $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Returns a new grid instance of the specified work order sessions.
     *
     * @param int|string $workOrderId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($workOrderId)
    {
        $columns = [
            'user_id',
            'in',
            'out',
        ];

        $settings = [
            'sort'      => 'in',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function ($session) {
            return [
                'user' => $session->user->full_name,
                'in'   => $session->in,
                'out'  => $session->viewer()->lblOut(),
            ];
        };

        return $this->workOrder->gridSessions($workOrderId, $columns, $settings, $transformer);
    }
}
