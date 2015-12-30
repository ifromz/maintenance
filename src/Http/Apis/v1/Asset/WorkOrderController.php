<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;

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
            'work_orders.priority_id',
            'work_orders.status_id',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 10,
        ];

        $transformer = function (WorkOrder $workOrder) use ($assetId) {
            return [
                'id'         => $workOrder->id,
                'created_at' => $workOrder->created_at,
                'subject'    => $workOrder->subject,
                'created_by' => $workOrder->user->full_name,
                'status'     => $workOrder->viewer()->lblStatus(),
                'priority'   => $workOrder->viewer()->lblPriority(),
                'view_url'   => route('maintenance.work-orders.show', [$workOrder->id]),
                'detach_url' => route('maintenance.assets.work-orders.attach.remove', [$assetId, $workOrder->id]),
            ];
        };

        return $this->asset->gridWorkOrders($assetId, $columns, $settings, $transformer);
    }

    /**
     * Returns a new grid instance of attachable work orders.
     *
     * @param int|string $assetId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridAttachable($assetId)
    {
        $columns = [
            'work_orders.id',
            'work_orders.created_at',
            'work_orders.user_id',
            'work_orders.subject',
            'work_orders.priority_id',
            'work_orders.status_id',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle'  => 10,
        ];

        $transformer = function (WorkOrder $workOrder) use ($assetId) {
            return [
                'id'         => $workOrder->id,
                'created_at' => $workOrder->created_at,
                'subject'    => $workOrder->subject,
                'created_by' => $workOrder->user->full_name,
                'status'     => $workOrder->viewer()->lblStatus(),
                'priority'   => $workOrder->viewer()->lblPriority(),
                'view_url'   => route('maintenance.work-orders.show', [$workOrder->id]),
                'attach_url' => route('maintenance.assets.work-orders.attach.store', [$assetId, $workOrder->id]),
            ];
        };

        return $this->asset->gridAttachableWorkOrders($assetId, $columns, $settings, $transformer);
    }
}
