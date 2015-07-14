<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin\Archive;

use Stevebauman\Maintenance\Repositories\Inventory\Repository as InventoryRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class InventoryController extends Controller
{
    /**
     * Constructor.
     *
     * @param InventoryRepository $inventory
     */
    public function __construct(InventoryRepository $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Displays the archived inventory items.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::admin.archive.inventory.index');
    }

    /**
     * Displays the specified archived inventory item.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $item = $this->inventory->model()->onlyTrashed()->findOrFail($id);

        return view('maintenance::admin.archive.inventory.show', compact('item'));
    }

    /**
     * Deletes the specified archived inventory item.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $item = $this->inventory->model()->onlyTrashed()->findOrFail($id);

        if($item->forceDelete()) {
            $message = 'Successfully deleted inventory item.';

            return redirect()->route('maintenance.admin.archive.inventory.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this inventory item. Please try again.';

            return redirect()->route('maintenance.admin.archive.inventory.show', [$id])->withErrors($message);
        }
    }

    /**
     * Restores the specified archived inventory item.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $item = $this->inventory->model()->onlyTrashed()->findOrFail($id);

        if ($item->restore()) {
            $message = 'Successfully restored inventory item.';

            return redirect()->route('maintenance.admin.archive.work-orders.index')->withSuccess($message);
        } else {
            $message = 'There was an error trying to restore this inventory item. Please try again.';

            return redirect()->route('maintenance.admin.archive.work-orders.index')->withSuccess($message);
        }
    }
}
