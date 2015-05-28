<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkRequest;

use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;
use Stevebauman\Maintenance\Repositories\WorkRequest\Repository;

class Controller extends BaseController
{
    /**
     * @var Repository
     */
    protected $workRequest;

    /**
     * Constructor.
     *
     * @param Repository $workRequest
     */
    public function __construct(Repository $workRequest)
    {
        $this->workRequest = $workRequest;
    }

    /**
     * Returns a new work request grid.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'subject',
            'best_time',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function($element)
        {
            $element->view_url = route('maintenance.work-requests.show', [$element->id]);

            return $element;
        };

        return $this->workRequest->grid($columns, $settings, $transformer);
    }
}
