<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Models\WorkOrderAssignment;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

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
            'created_at',
            'user_id',
            'subject',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function(WorkOrderAssignment $assignment)
        {
            return [
                'id' => $assignment->id,
                'created_at' => $assignment->created_at,
                'subject' => $assignment->subject,
                'view_url' => route('maintenance.work-orders.show', [$assignment->id]),
                'created_by' => $assignment->user->full_name,
                'status' => $assignment->viewer()->lblStatus(),
                'priority' =>  $assignment->viewer()->lblPriority(),
            ];
        };

        return $this->workOrder->gridAssigned($columns, $settings, $transformer);
    }
}
