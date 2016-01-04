<?php

namespace App\Http\Apis\v1\WorkOrder;

use App\Http\Apis\v1\Controller as BaseController;
use App\Models\WorkOrder;
use App\Repositories\WorkOrder\Repository;

class Controller extends BaseController
{
    /**
     * @var Repository
     */
    protected $workOrder;

    /**
     * @param Repository $workOrder
     */
    public function __construct(Repository $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Returns a new work order grid.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'priority_id',
            'status_id',
            'created_at',
            'user_id',
            'subject',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function (WorkOrder $workOrder) {
            return [
                'id'         => $workOrder->id,
                'created_at' => $workOrder->created_at,
                'subject'    => str_limit($workOrder->subject),
                'view_url'   => route('maintenance.work-orders.show', [$workOrder->id]),
                'created_by' => $workOrder->user->full_name,
                'status'     => $workOrder->viewer()->lblStatus(),
                'priority'   => $workOrder->viewer()->lblPriority(),
            ];
        };

        return $this->workOrder->grid($columns, $settings, $transformer);
    }
}
