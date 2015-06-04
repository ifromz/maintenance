<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Inventory;

use Stevebauman\Maintenance\Http\Requests\Inventory\Stock\Request;
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

        return $this->responseJson([
            'html' => view('maintenance::inventory.modals.stocks.edit', [
                    'item' => $item,
                    'stock' => $stock,
            ])->render(),
        ]);
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
