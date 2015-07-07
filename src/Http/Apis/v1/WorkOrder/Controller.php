<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

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
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 10,
        ];

        $transformer = function(WorkOrder $workOrder)
        {
            return [
                'id' => $workOrder->id,
                'created_at' => $workOrder->created_at,
                'subject' => $workOrder->subject,
                'view_url' => route('maintenance.work-orders.show', [$workOrder->id]),
                'created_by' => $workOrder->user->full_name,
                'status' => $workOrder->viewer()->lblStatus(),
                'priority' =>  $workOrder->viewer()->lblPriority(),
            ];
        };

        return $this->workOrder->grid($columns, $settings, $transformer);
    }
}
