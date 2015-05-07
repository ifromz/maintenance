<?php

namespace Stevebauman\Maintenance\Apis\v1\Inventory;

use Stevebauman\Maintenance\Services\Inventory\StockService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Apis\v1\BaseApi;

class StockApi extends BaseApi
{
    public function __construct(InventoryService $inventory, StockService $inventoryStock)
    {
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
    }

    public function edit($inventory_id, $stock_id)
    {
        $item = $this->inventory->find($inventory_id);

        $stock = $this->inventoryStock->find($stock_id);

        return $this->responseJson([
            'html' => view('maintenance::inventory.modals.stocks.edit', [
                    'item' => $item,
                    'stock' => $stock,
            ])->render(),
        ]);
    }

    public function update($inventory_id, $stock_id)
    {
        $data = $this->inputAll();
        $data['inventory_id'] = $inventory_id;

        return $this->inventoryStock->setInput($data)->update($stock_id);
    }
}
