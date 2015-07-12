<?php

namespace Stevebauman\Maintenance\Http\Controllers\Inventory;

use Stevebauman\Maintenance\Http\Requests\Inventory\Stock\Request as StockRequest;
use Stevebauman\Maintenance\Repositories\Inventory\StockRepository;
use Stevebauman\Maintenance\Repositories\Inventory\Repository as InventoryRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class StockController extends BaseController
{
    /**
     * @var InventoryRepository
     */
    protected $inventory;

    /**
     * @var StockRepository
     */
    protected $stock;

    /**
     * Constructor.
     *
     * @param InventoryRepository $inventory
     * @param StockRepository     $stock
     */
    public function __construct(InventoryRepository $inventory, StockRepository $stock)
    {
        $this->inventory = $inventory;
        $this->stock = $stock;
    }

    /**
     * Displays all inventory stock entries.
     *
     * @param int|string $itemId
     *
     * @return \Illuminate\View\View
     */
    public function index($itemId)
    {
        $item = $this->inventory->find($itemId);

        return view('maintenance::inventory.stocks.index', compact('item'));
    }

    /**
     * Displays the form for creating a new stock entry for the inventory.
     *
     * @param int|string $itemId
     *
     * @return \Illuminate\View\View
     */
    public function create($itemId)
    {
        $item = $this->inventory->find($itemId);

        return view('maintenance::inventory.stocks.create', compact('item'));
    }

    /**
     * Create a new stock entry for the specified inventory item.
     *
     * @param StockRequest $request
     * @param int|string   $itemId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StockRequest $request, $itemId)
    {
        $item = $this->inventory->find($itemId);

        $stock = $this->stock->create($request, $item->id);

        if($stock) {
            $message = 'Successfully created stock.';

            return redirect()->route('maintenance.inventory.stocks.show', [$item->id, $stock->id])->withSuccess($message);
        } else {
            $message = 'There was an issue creating a stock. Please try again.';

            return redirect()->route('maintenance.inventory.stocks.create', [$item->id])->withErrors($message);
        }
    }

    /**
     * Displays the specified stock entry for the specified inventory.
     *
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function show($itemId, $stockId)
    {
        $item = $this->inventory->find($itemId);

        $stock = $item->stocks()->find($stockId);

        if($stock) {
            return view('maintenance::inventory.stocks.show', compact('item', 'stock'));
        }

        abort(404);
    }

    /**
     * Displays the edit form for the specified stock for the specified inventory.
     *
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return \Illuminate\View\View
     */
    public function edit($itemId, $stockId)
    {
        $item = $this->inventory->find($itemId);

        $stock = $item->stocks()->find($stockId);

        if($stock) {
            return view('maintenance::inventory.stocks.edit', compact('item', 'stock'));
        }

        abort(404);
    }

    /**
     * Updates the specified stock for the specified inventory.
     *
     * @param StockRequest $request
     * @param int|string   $itemId
     * @param int|string   $stockId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StockRequest $request, $itemId, $stockId)
    {
        $item = $this->inventory->find($itemId);

        $stock = $this->stock->update($request, $item->id, $stockId);

        if($stock) {
            $message = 'Successfully updated stock.';

            return redirect()->route('maintenance.inventory.stocks.show', [$item->id, $stock->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this stock. Please try again.';

            return redirect()->route('maintenance.inventory.stocks.update', [$itemId, $stockId])->withErrors($message);
        }
    }

    /**
     * Removes the specified stock from the specified inventory.
     *
     * @param int|string $itemId
     * @param int|string $stockId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($itemId, $stockId)
    {
        $item = $this->inventory->find($itemId);

        $stock = $item->stocks()->find($stockId);

        if($stock && $stock->delete()) {
            $message = 'Successfully deleted stock.';

            return redirect()->route('maintenance.inventory.stocks.index', [$item->id])->withSuccess($message);
        }

        abort(404);
    }
}
