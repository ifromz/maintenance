<?php

namespace App\Processors\Inventory;

use App\Http\Presenters\Inventory\InventoryStockPresenter;
use App\Http\Requests\Inventory\InventoryStockRequest;
use App\Models\Inventory;
use App\Processors\Processor;

class InventoryStockProcessor extends Processor
{
    /**
     * @var Inventory
     */
    protected $inventory;

    /**
     * @var InventoryStockPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Inventory               $inventory
     * @param InventoryStockPresenter $presenter
     */
    public function __construct(Inventory $inventory, InventoryStockPresenter $presenter)
    {
        $this->inventory = $inventory;
        $this->presenter = $presenter;
    }

    /**
     * Displays all stocks for the specified inventory item.
     *
     * @param int|string $itemId
     *
     * @return \Illuminate\View\View
     */
    public function index($itemId)
    {
        $item = $this->inventory->findOrFail($itemId);

        $navbar = $this->presenter->navbar($item);

        $stocks = $this->presenter->table($item);

        return view('inventory.stocks.index', compact('stocks', 'navbar'));
    }

    /**
     * Displays the from for creating a stock for.
     *
     * @param int|string $itemId
     *
     * @return \Illuminate\View\View
     */
    public function create($itemId)
    {
        $item = $this->inventory->findOrFail($itemId);

        $form = $this->presenter->form($item, $item->stocks()->getRelated());

        return view('inventory.stocks.create', compact('form'));
    }

    /**
     * Creates a new stock on the specified item.
     *
     * @param InventoryStockRequest $request
     * @param int|string            $itemId
     *
     * @return bool
     */
    public function store(InventoryStockRequest $request, $itemId)
    {
        $item = $this->inventory->findOrFail($itemId);

        $stock = $item->stocks()->getRelated();

        $stock->user_id = auth()->id();
        $stock->inventory_id = $item->getKey();
        $stock->location_id = $request->input('location');
        $stock->quantity = $request->input('quantity');
        $stock->cost = $request->input('cost');
        $stock->reason = $request->input('reason');

        return $stock->save();
    }

    /**
     * Displays the specified items stock.
     *
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function show($itemId, $stockId)
    {
        $item = $this->inventory->findOrFail($itemId);

        $stock = $item->stocks()->findOrFail($stockId);

        return view('inventory.stocks.show', compact('item', 'stock'));
    }

    /**
     * Displays the form for editing the specified items stock.
     *
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function edit($itemId, $stockId)
    {
        $item = $this->inventory->findOrFail($itemId);

        $stock = $item->stocks()->findOrFail($stockId);

        $form = $this->presenter->form($item, $stock);

        return view('inventory.stocks.edit', compact('form'));
    }

    /**
     * Updates the specified inventory stock.
     *
     * @param InventoryStockRequest $request
     * @param int|string            $itemId
     * @param int|string            $stockId
     *
     * @return bool
     */
    public function update(InventoryStockRequest $request, $itemId, $stockId)
    {
        $item = $this->inventory->findOrFail($itemId);

        $stock = $item->stocks()->findOrFail($stockId);

        $stock->location_id = $request->input('location', $stock->location_id);
        $stock->quantity = $request->input('quantity', $stock->quantity);
        $stock->cost = $request->input('cost');
        $stock->reason = $request->input('reason');

        return $stock->save();
    }

    /**
     * Deletes the specified inventory stock.
     *
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return bool
     */
    public function destroy($itemId, $stockId)
    {
        $item = $this->inventory->findOrFail($itemId);

        $stock = $item->stocks()->findOrFail($stockId);

        return $stock->delete();
    }
}
