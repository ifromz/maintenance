<?php

namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\InventoryValidator;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class InventoryController
 * @package Stevebauman\Maintenance\Controllers\Inventory
 */
class InventoryController extends BaseController
{

    /**
     * @var InventoryService
     */
    protected $inventory;

    /**
     * @var InventoryValidator
     */
    protected $inventoryValidator;

    public function __construct(InventoryService $inventory, InventoryValidator $inventoryValidator)
    {
        $this->inventory = $inventory;
        $this->inventoryValidator = $inventoryValidator;
    }

    /**
     * Display all inventory entries (paginated with search functionality)
     *
     * @return mixed
     */
    public function index()
    {
        $transaction = \Stevebauman\Maintenance\Models\InventoryTransaction::find(2);

        $transaction->sold(4);

        $items = $this->inventory->setInput($this->inputAll())->getByPageWithFilter();

        return view('maintenance::inventory.index', array(
            'title' => 'Inventory',
            'items' => $items,
        ));
    }

    /**
     * Show the form for creating an inventory
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::inventory.create', array(
            'title' => 'Add an Item to the Inventory',
        ));
    }

    /**
     * Store a new inventory
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store()
    {
        $this->inventoryValidator->unique('name', $this->inventory->getTableName(), 'name');

        if ($this->inventoryValidator->passes()) {

            $record = $this->inventory->setInput($this->inputAll())->create();

            if ($record) {
                $this->message = sprintf('Successfully added item to the inventory: %s', link_to_route('maintenance.inventory.show', 'Show', array($record->id)));
                $this->messageType = 'success';
                $this->redirect = route('maintenance.inventory.index');

            } else {
                $this->message = 'There was an error adding this item to the inventory. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.inventory.create');
            }

        } else {
            $this->errors = $this->inventoryValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Display the specified inventory
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $item = $this->inventory->find($id);

        return view('maintenance::inventory.show', array(
            'title' => 'Viewing Inventory Item: ' . $item->name,
            'item' => $item,
        ));
    }

    /**
     * Displays the edit form for the specified inventory
     *
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $item = $this->inventory->find($id);

        return view('maintenance::inventory.edit', array(
            'title' => 'Editing Inventory Item: ' . $item->name,
            'item' => $item,
        ));
    }

    /**
     * Updates the specified inventory
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update($id)
    {
        $this->inventoryValidator->ignore('name', $this->inventory->getTableName(), 'name', $id);

        if ($this->inventoryValidator->passes()) {

            $item = $this->inventory->setInput($this->inputAll())->update($id);

            if ($item) {
                $this->message = sprintf('Successfully updated item: %s', link_to_route('maintenance.inventory.show', 'Show', array($item->id)));
                $this->messageType = 'success';
                $this->redirect = route('maintenance.inventory.show', array($item->id));

            } else {
                $this->message = 'There was an error trying to update this item. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.inventory.edit', array($item->id));
            }

        } else {
            $this->errors = $this->inventoryValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Removes the specified inventory
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($id)
    {
        $this->inventory->destroy($id);

        $this->redirect = route('maintenance.inventory.index');
        $this->message = 'Successfully deleted item';
        $this->messageType = 'success';

        return $this->response();
    }
}
