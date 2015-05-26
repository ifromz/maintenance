<?php

namespace Stevebauman\Maintenance\Controllers\Admin\Archive;

use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Controllers\BaseController;

class InventoryController extends BaseController
{
    /**
     * Constructor.
     *
     * @param InventoryService $inventory
     */
    public function __construct(InventoryService $inventory)
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
        $items = $this->inventory->setInput($this->inputAll())->getByPageWithFilter(true);

        return view('maintenance::admin.archive.inventory.index', [
            'title' => 'Archived Inventory Items',
            'items' => $items,
        ]);
    }

    /**
     * Displays the specified archived inventory item.
     *
     * @param string|int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $item = $this->inventory->findArchived($id);

        return view('maintenance::admin.archive.inventory.show', [
            'title' => 'Viewing Archived Inventory Item: '.$item->name,
            'item' => $item,
        ]);
    }

    /**
     * Deletes the specified archived inventory item.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->inventory->destroyArchived($id);

        $this->message = 'Successfully deleted inventory item';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.admin.archive.inventory.index');

        return $this->response();
    }

    /**
     * Restores the specified archived inventory item.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        if ($this->inventory->restoreArchived($id)) {
            $this->message = sprintf('Successfully restored inventory item. %s', link_to_route('maintenance.inventory.show', 'Show', $id));
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.work-orders.index');
        } else {
            $this->message = 'There was an error trying to restore this inventory item, please try again';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.inventory.index');
        }

        return $this->response();
    }
}
