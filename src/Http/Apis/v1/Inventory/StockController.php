<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Inventory;

use Stevebauman\Maintenance\Http\Requests\Inventory\Stock\Request;
use Stevebauman\Maintenance\Models\InventoryStock;
use Stevebauman\Maintenance\Models\InventoryStockMovement;
use Stevebauman\Maintenance\Repositories\Inventory\StockRepository;
use Stevebauman\Maintenance\Repositories\Inventory\Repository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class StockController extends BaseController
{
    /**
     * Constructor.
     *
     * @param Repository      $inventory
     * @param StockRepository $inventoryStock
     */
    public function __construct(Repository $inventory, StockRepository $inventoryStock)
    {
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
    }

    /**
     * Returns a new grid instance of the specified inventory's stocks.
     *
     * @param int|string $id
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($id)
    {
        $columns = [
            'id',
            'quantity',
            'inventory_id',
            'location_id',
            'created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 11,
        ];

        $transformer = function(InventoryStock $stock) use ($id)
        {
            return [
                'id' => $stock->id,
                'quantity' => $stock->getQuantityMetricAttribute(),
                'location' => ($stock->location ? $stock->location->trail : null),
                'last_movement' => $stock->getLastMovementAttribute(),
                'last_movement_by' => $stock->getLastMovementByAttribute(),
                'created_at' => $stock->created_at,
                'view_url' => route('maintenance.inventory.stocks.show', [$id, $stock->id]),
            ];
        };

        return $this->inventory->gridStocks($id, $columns, $settings, $transformer);
    }

    /**
     * Returns a new grid instance of all stock movements.
     *
     * @param int|string $id
     * @param int|string $stockId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridMovements($id, $stockId)
    {
        $columns = [
            'id',
            'user_id',
            'stock_id',
            'before',
            'after',
            'cost',
            'reason',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 11,
        ];

        $transformer = function(InventoryStockMovement $movement) use ($id, $stockId)
        {
            return [
                'id' => $movement->id,
                'before' => $movement->before,
                'after' => $movement->after,
                'cost' => $movement->cost,
                'reason' => $movement->reason,
                'change' => $movement->getChangeAttribute(),
                'user' => ($movement->user ? $movement->user->full_name : '<em>None</em>'),
                'created_at' => $movement->created_at,
                'view_url' => route('maintenance.inventory.stocks.movements.show', [$id, $stockId, $movement->id]),
            ];
        };

        return $this->inventory->gridStockMovements($id, $stockId, $columns, $settings, $transformer);
    }

    /**
     * Displays the form for editing an inventory stock.
     *
     * @param int|string $inventoryId
     * @param int|string $stockId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($inventoryId, $stockId)
    {
        $item = $this->inventory->find($inventoryId);

        $stock = $this->inventoryStock->find($stockId);

        return [
            'html' => view('maintenance::inventory.modals.stocks.edit', [
                    'item' => $item,
                    'stock' => $stock,
            ])->render(),
        ];
    }

    /**
     * Processes updating the specified inventory stock.
     *
     * @param Request    $request
     * @param int|string $inventoryId
     * @param int|string $stockId
     *
     * @return bool|static
     */
    public function update(Request $request, $inventoryId, $stockId)
    {
        return $this->inventoryStock->update($request, $inventoryId, $stockId);
    }
}
