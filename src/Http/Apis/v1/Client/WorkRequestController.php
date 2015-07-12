<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Client;

use Stevebauman\Maintenance\Models\WorkRequest;
use Stevebauman\Maintenance\Repositories\Client\WorkRequestRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class WorkRequestController extends BaseController
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
     * Returns a new grid instance of all of the current users work requests.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'subject',
            'description',
            'best_time',
            'created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 11,
        ];

        $transformer = function(WorkRequest $workRequest)
        {
            $attributes = [
                'id' => $workRequest->id,
                'subject' => $workRequest->subject,
                'description' => $workRequest->getLimitedDescriptionAttribute(),
                'best_time' => $workRequest->best_time,
                'created_at' => $workRequest->created_at,
                'view_url' => route('maintenance.client.work-requests.show', [$workRequest->id]),
            ];

            if($workRequest->workOrder && $workRequest->workOrder->status) {
                $attributes['status'] = $workRequest->workOrder->status->label;
            } else {
                $attributes['status'] = '<em>None</em>';
            }

            return $attributes;
        };

        return $this->workRequest->grid($columns, $settings, $transformer);
    }
}
