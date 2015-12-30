<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;
use Stevebauman\Maintenance\Models\Priority;
use Stevebauman\Maintenance\Repositories\WorkOrder\PriorityRepository;

class PriorityController extends BaseController
{
    /**
     * @var PriorityRepository
     */
    protected $priority;

    /**
     * @param PriorityRepository $priority
     */
    public function __construct(PriorityRepository $priority)
    {
        $this->priority = $priority;
    }

    /**
     * Returns a new work order status grid.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'created_at',
            'user_id',
            'name',
            'color',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 11,
        ];

        $transformer = function (Priority $priority) {
            return [
                'id'         => $priority->id,
                'created_at' => $priority->created_at,
                'created_by' => ($priority->user ? $priority->user->full_name : '<em>System</em>'),
                'name'       => $priority->name,
                'color'      => $priority->color,
                'view_url'   => route('maintenance.work-orders.priorities.edit', [$priority->id]),
            ];
        };

        return $this->priority->grid($columns, $settings, $transformer);
    }
}
