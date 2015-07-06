<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Inventory;

use Stevebauman\Maintenance\Http\Requests\Inventory\Stock\Request;
use Stevebauman\Maintenance\Models\InventoryStock;
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
            'location_id',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function(InventoryStock $stock) use ($id)
        {
            return [
                'id' => $stock->id,
                'quantity' => $stock->quantity,
                'location' => ($stock->location ? $stock->location->trail : null),
                'last_movement' => $stock->getLastMovement(),
                'created_at' => $stock->created_at,
                'view_url' => route('maintenance.inventory.stocks.show', [$id, $stock->id]),
            ];
        };

        return $this->inventory->gridStocks($id, $columns, $settings, $transformer);
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
