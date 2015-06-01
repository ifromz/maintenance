<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Inventory;

use Stevebauman\Maintenance\Services\Inventory\StockService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Http\Apis\v1\BaseApi;

class StockController extends BaseApi
{
    /**
     * Constructor.
     *
     * @param InventoryService $inventory
     * @param StockService $inventoryStock
     */
    public function __construct(InventoryService $inventory, StockService $inventoryStock)
    {
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
    }

    /**
     * Displays the form for editing an inventory stock.
     *
     * @param $inventoryId
     * @param $stockId
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
     * @param $inventoryId
     * @param $stockId
     *
     * @return bool|static
     */
    public function update($inventoryId, $stockId)
    {
        $data = $this->inputAll();
        $data['inventory_id'] = $inventoryId;

        return $this->inventoryStock->setInput($data)->update($stockId);
    }
}
