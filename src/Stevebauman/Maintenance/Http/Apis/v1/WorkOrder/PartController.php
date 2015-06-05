<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Repositories\Inventory\Repository as InventoryRepository;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class PartController extends BaseController
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * @var InventoryRepository
     */
    protected $inventory;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     * @param InventoryRepository $inventory
     */
    public function __construct(WorkOrderRepository $workOrder, InventoryRepository $inventory)
    {
        $this->workOrder = $workOrder;
        $this->inventory = $inventory;
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
        $workOrder = $this->workOrder->find($workOrderId);

        $columns = [
            'inventory_id',
            'location_id',
        ];

        $settings = [];

        $transformer = function($stock) use ($workOrder)
        {
            return [
                'item_id' => $stock->inventory_id,
                'item_sku' => ($stock->item->sku_code ? $stock->item->sku_code : '<em>None</em>'),
                'item_name' => $stock->item->name,
                'item_view_url' => route('maintenance.inventory.show', [$stock->inventory_id]),
                'location' => ($stock->location ? $stock->location->trail : '<em>None</em>'),
                'quantity_taken' => $stock->pivot->quantity,
                'date_taken' => $stock->pivot->created_at->format('Y-m-d h:i a'),
                'put_back_url' => '',
            ];
        };

        return $this->workOrder->gridParts($workOrderId, $columns, $settings, $transformer);
    }

    /**
     * Returns a new grid instance of
     * selectable inventory items.
     *
     * @param int|string $workOrderId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridInventory($workOrderId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        $columns = [
            'id',
            'name',
            'category_id',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function($item) use ($workOrder)
        {
            return [
                'id' => $item->id,
                'sku' => ($item->sku_code ? $item->sku_code : '<em>None</em>'),
                'name' => $item->name,
                'category' => ($item->category ? $item->category->trail : null),
                'current_stock' => $item->viewer()->lblCurrentStock(),
                'created_at' => $item->created_at,
                'view_url' => route('maintenance.inventory.show', [$item->id]),
                'select_url' => route('maintenance.work-orders.parts.stocks.index', [$workOrder->id, $item->id]),
            ];
        };

        return $this->inventory->grid($columns, $settings, $transformer);
    }
}
