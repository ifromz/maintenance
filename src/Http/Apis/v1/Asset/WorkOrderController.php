<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class WorkOrderController extends BaseController
{
    /**
     * @var AssetRepository
     */
    protected $asset;

    /**
     * Constructor.
     *
     * @param AssetRepository $asset
     */
    public function __construct(AssetRepository $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Returns a new asset work order grid.
     *
     * @param int|string $assetId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($assetId)
    {
        $columns = [
            'work_orders.id',
            'work_orders.created_at',
            'work_orders.user_id',
            'work_orders.subject',
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

        return $this->asset->gridWorkOrders($assetId, $columns, $settings, $transformer);
    }
}
