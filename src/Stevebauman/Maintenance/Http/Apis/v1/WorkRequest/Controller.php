<?php

use Stevebauman\Maintenance\Apis\v1\Controller as BaseController;

use Stevebauman\Maintenance\Repositories\WorkRequestRepository;

class Controller extends BaseController
{
    /**
     * @var WorkRequestRepository
     */
    protected $workRequest;

    /**
     * Constructor.
     *
     * @param WorkRequestRepository $workRequest
     */
    public function __construct(WorkRequestRepository $workRequest)
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

        };

        return $this->workRequest->grid($columns, $settings, $transformer);
    }
}
