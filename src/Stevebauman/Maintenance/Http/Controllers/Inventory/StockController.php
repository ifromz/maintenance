<?php

namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\Inventory\StockValidator;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Services\Inventory\StockService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class StockController.
 */
class StockController extends BaseController
{
    /**
     * @var InventoryService
     */
    protected $inventory;

    /**
     * @var StockService
     */
    protected $inventoryStock;

    /**
     * @var StockValidator
     */
    protected $inventoryStockValidator;

    /**
     * @param InventoryService $inventory
     * @param StockService     $inventoryStock
     * @param StockValidator   $inventoryStockValidator
     */
    public function __construct(
        InventoryService $inventory,
        StockService $inventoryStock,
        StockValidator $inventoryStockValidator
    ) {
        $this->inventory = $inventory;
        $this->inventoryStock = $inventoryStock;
        $this->inventoryStockValidator = $inventoryStockValidator;
    }

    /**
     * Displays all inventory stock entries.
     *
     * @param $inventory_id
     *
     * @return mixed
     */
    public function index($inventory_id)
    {
        $item = $this->inventory->find($inventory_id);

        return view('maintenance::inventory.stocks.index', [
            'title' => 'Current Stocks for Item: '.$item->name,
            'item' => $item,
        ]);
    }

    /**
     * Displays the form for creating a new stock entry for the inventory.
     *
     * @param $inventory_id
     *
     * @return mixed
     */
    public function create($inventory_id)
    {
        $item = $this->inventory->find($inventory_id);

        return view('maintenance::inventory.stocks.create', [
            'title' => 'Add Stock Location to: '.$item->name,
            'item' => $item,
        ]);
    }

    /**
     * Create a new stock entry for the inventory.
     *
     * @param $inventory_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($inventory_id)
    {
        if ($this->inventoryStockValidator->passes()) {
            $item = $this->inventory->find($inventory_id);

            $data = $this->inputAll();
            $data['inventory_id'] = $item->id;

            $record = $this->inventoryStock->setInput($data)->create();

            if ($record) {
                $this->message = 'Successfully added stock to this item';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.inventory.show', [$item->id]);
            } else {
                $this->message = 'There was an error trying to add stock to this item. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.inventory.show', [$item->id]);
            }
        } else {
            $this->errors = $this->inventoryStockValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Displays the specified stock entry for the specified inventory.
     *
     * @param $inventory_id
     * @param $stock_id
     *
     * @return mixed
     */
    public function show($inventory_id, $stock_id)
    {
        $item = $this->inventory->find($inventory_id);

        $stock = $this->inventoryStock->find($stock_id);

        $lastMovements = $stock->movements()->take(10)->get();

        return view('maintenance::inventory.stocks.show', [
            'title' => sprintf('Viewing Stock for item: %s inside Location: %s', $item->name, renderNode($stock->location)),
            'item' => $item,
            'stock' => $stock,
            'lastMovements' => $lastMovements,
        ]);
    }

    /**
     * Displays the edit form for the specified stock for the specified inventory.
     *
     * @param $inventory_id
     * @param $stock_id
     *
     * @return mixed
     */
    public function edit($inventory_id, $stock_id)
    {
        $item = $this->inventory->find($inventory_id);

        $stock = $this->inventoryStock->find($stock_id);

        return view('maintenance::inventory.stocks.edit', [
            'title' => sprintf('Update Stock for item: %s inside %s', $item->name, $stock->location->name),
            'stock' => $stock,
            'item' => $item,
        ]);
    }

    /**
     * Updates the specified stock for the specified inventory.
     *
     * @param $inventory_id
     * @param $stock_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update($inventory_id, $stock_id)
    {
        if ($this->inventoryStockValidator->passes()) {
            $item = $this->inventory->find($inventory_id);

            $stock = $this->inventoryStock->setInput($this->inputAll())->update($stock_id);

            if ($stock) {
                $this->message = 'Successfully updated stock for item: '.$item->name;
                $this->messageType = 'success';
                $this->redirect = route('maintenance.inventory.show', [$item->id]);
            } else {
                $this->message = 'There was an error trying to update the stock for this item. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.inventory.show', [$item->id]);
            }
        } else {
            $this->redirect = route('maintenance.inventory.show', [$inventory_id]);
            $this->errors = $this->inventoryStockValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Removes the specified stock from the specified inventory.
     *
     * @param $inventory_id
     * @param $stock_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($inventory_id, $stock_id)
    {
        if ($this->inventoryStock->destroy($stock_id)) {
            $this->message = 'Successfully deleted stock';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.inventory.show', [$inventory_id]);
        } else {
            $this->message = 'There was an error trying to delete the stock for this item. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.inventory.show', [$inventory_id]);
        }

        return $this->response();
    }
}
