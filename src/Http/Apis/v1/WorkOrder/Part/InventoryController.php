<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder\Part;

use Stevebauman\Maintenance\Models\Inventory;
use Stevebauman\Maintenance\Models\InventoryStock;
use Stevebauman\Maintenance\Repositories\Inventory\StockRepository as InventoryStockRepository;
use Stevebauman\Maintenance\Repositories\Inventory\Repository as InventoryRepository;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class InventoryController extends BaseController
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
     * @var InventoryStockRepository
     */
    protected $inventoryStock;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository      $workOrder
     * @param InventoryRepository      $inventory
     * @param InventoryStockRepository $inventoryStock
     */
    public function __construct(
        WorkOrderRepository $workOrder,
        InventoryRepository $inventory,
        InventoryStockRepository $inventoryStock
    ) {
        $this->workOrder = $workOrder;
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
    }

    /**
     * Returns a new grid instance of all available
     * inventory items for selection.
     *
     * @param int|string $workOrderId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($workOrderId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        $columns = [
            'id',
            'name',
            'category_id',
            'created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 11,
        ];

        $transformer = function(Inventory $item) use ($workOrder)
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

    /**
     * Returns a new grid instance of all available
     * inventory stocks for selection.
     *
     * @param int|string $workOrderId
     * @param int|string $inventoryId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridStocks($workOrderId, $inventoryId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        $columns = [
            'id',
            'location_id',
            'quantity',
            'created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 11,
        ];

        $transformer = function(InventoryStock $stock) use ($workOrder, $inventoryId)
        {
            return [
                'id' => $stock->id,
                'location' => ($stock->location ? $stock->location->trail : '<em>None</em>'),
                'quantity' => $stock->quantity,
                'select_url' => route('maintenance.work-orders.parts.stocks.take', [$workOrder->id, $inventoryId, $stock->id]),
            ];
        };

        return $this->inventory->gridStocks($inventoryId, $columns, $settings, $transformer);
    }

    /**
     * Returns a new grid instance of all available
     * inventory variants for selection.
     *
     * @param int|string $workOrderId
     * @param int|string $inventoryId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridVariants($workOrderId, $inventoryId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        $columns = [
            'id',
            'name',
            'category_id',
            'created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 11,
        ];

        $transformer = function(Inventory $item) use ($workOrder)
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

        return $this->inventory->gridVariants($inventoryId, $columns, $settings, $transformer);
    }
}
