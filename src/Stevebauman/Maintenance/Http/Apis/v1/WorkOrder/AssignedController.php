<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

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

        $transformer = function($element)
        {
            return [
                'id' => $element->id,
                'created_at' => $element->created_at,
                'subject' => $element->subject,
                'view_url' => route('maintenance.work-orders.show', [$element->id]),
                'created_by' => $element->user->full_name,
                'status' => $element->viewer()->lblStatus(),
                'priority' =>  $element->viewer()->lblPriority(),
            ];
        };

        return $this->workOrder->gridAssigned($columns, $settings, $transformer);
    }
}
