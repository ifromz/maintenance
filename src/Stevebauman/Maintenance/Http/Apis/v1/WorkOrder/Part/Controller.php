<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder\Part;

use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository      $workOrder
     */
    public function __construct(WorkOrderRepository $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Returns a new grid instance of
     * parts added to the specified work order.
     *
     * @param int|string $workOrderId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($workOrderId)
    {
        $columns = [
            'inventory_stocks.id',
            'inventory_id',
            'location_id',
        ];

        $settings = [];

        $transformer = function($stock) use ($workOrderId)
        {
            return [
                'item_id' => $stock->inventory_id,
                'item_sku' => ($stock->item->sku_code ? $stock->item->sku_code : '<em>None</em>'),
                'item_name' => $stock->item->name,
                'item_view_url' => route('maintenance.inventory.show', [$stock->inventory_id]),
                'location' => ($stock->location ? $stock->location->trail : '<em>None</em>'),
                'quantity_taken' => $stock->pivot->quantity,
                'date_taken' => $stock->pivot->created_at->format('Y-m-d h:i a'),
                'put_back_url' => route('maintenance.work-orders.parts.stocks.put', [$workOrderId, $stock->inventory_id, $stock->id]),
            ];
        };

        return $this->workOrder->gridParts($workOrderId, $columns, $settings, $transformer);
    }
}
