<?php

namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\Inventory\StockService;
use Stevebauman\Maintenance\Services\Inventory\StockMovementService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class StockMovementController
 * @package Stevebauman\Maintenance\Controllers\Inventory
 */
class StockMovementController extends BaseController
{

    public function __construct(InventoryService $inventory, StockService $inventoryStock, StockMovementService $inventoryStockMovement)
    {
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
        $this->inventoryStockMovement = $inventoryStockMovement;
    }

    /**
     * Displays all the stock movement entries for the specified stock for the
     * specified inventory
     *
     * @param $inventory_id
     * @param $stock_id
     * @return mixed
     */
    public function index($inventory_id, $stock_id)
    {

        $item = $this->inventory->find($inventory_id);
        $stock = $this->inventoryStock->find($stock_id);

        $data = $this->inputAll();
        $data['stock_id'] = $stock->id;

        $movements = $this->inventoryStockMovement->setInput($data)->getByPageWithFilter();

        return view('maintenance::inventory.stocks.movements.index', array(
            'title' => "Viewing Stock Movements for Item: $item->name in Location: " . renderNode($stock->location),
            'item' => $item,
            'stock' => $stock,
            'movements' => $movements
        ));

    }

    /**
     * Displays a stock movement record
     *
     * @param $inventory_id
     * @param $stock_id
     * @param $movement_id
     */
    public function show($inventory_id, $stock_id, $movement_id)
    {

    }


}
