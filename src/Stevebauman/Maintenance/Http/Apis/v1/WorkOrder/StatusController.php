<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Repositories\WorkOrder\StatusRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class StatusController extends BaseController
{
    /**
     * @var StatusRepository
     */
    protected $status;

    /**
     * @param StatusRepository $status
     */
    public function __construct(StatusRepository $status)
    {
        $this->status = $status;
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
        ];

        $transformer = function($element)
        {
            return [
                'id' => $element->id,
                'created_at' => $element->created_at,
                'created_by' => ($element->user ? $element->user->full_name : 'None'),
                'name' => $element->name,
                'color' => $element->color,
                'view_url' => ''
            ];
        };

        return $this->status->grid($columns, $settings, $transformer);
    }
}
