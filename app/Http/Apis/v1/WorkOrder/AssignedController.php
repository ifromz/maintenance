<?php

namespace App\Http\Apis\v1\WorkOrder;

use App\Http\Apis\v1\Controller as BaseController;
use App\Models\WorkOrder;
use App\Repositories\WorkOrder\Repository;

class AssignedController extends BaseController
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
            'throttle'  => 10,
        ];

        $transformer = function (WorkOrder $assignment) {
            return [
                'id'         => $assignment->id,
                'created_at' => $assignment->created_at,
                'subject'    => $assignment->subject,
                'view_url'   => route('maintenance.work-orders.show', [$assignment->id]),
                'created_by' => $assignment->user->full_name,
                'status'     => $assignment->viewer()->lblStatus(),
                'priority'   => $assignment->viewer()->lblPriority(),
            ];
        };

        return $this->workOrder->gridAssigned($columns, $settings, $transformer);
    }
}
