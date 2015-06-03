<?php

namespace Stevebauman\Maintenance\Http\Controllers\Inventory;

use Stevebauman\Maintenance\Http\Requests\Inventory\Request;
use Stevebauman\Maintenance\Repositories\Inventory\Repository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

/**
 * Class InventoryController.
 */
class Controller extends BaseController
{
    /**
     * @var Repository
     */
    protected $inventory;

    /**
     * Constructor.
     *
     * @param Repository $inventory
     */
    public function __construct(Repository $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Display all inventory entries (paginated with search functionality).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::inventory.index');
    }

    /**
     * Show the form for creating an inventory.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::inventory.create');
    }

    /**
     * Store a new inventory.
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store(Request $request)
    {
        $inventory = $this->inventory->create($request);

        if($inventory) {
            $message = 'Successfully created inventory item.';

            return redirect()->route('maintenance.inventory.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating this inventory item. Please try again.';

            return redirect()->route('maintenance.inventory.index')->withErrors($message);
        }
    }

    /**
     * Display the specified inventory.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function show($id)
    {
        $item = $this->inventory->find($id);

        return view('maintenance::inventory.show', [
            'title' => 'Viewing Inventory Item: '.$item->name,
            'item' => $item,
        ]);
    }

    /**
     * Displays the edit form for the specified inventory.
     *
     * @param int|string $id
     *
     * @return mixed
     */
    public function edit($id)
    {
        $item = $this->inventory->find($id);

        return view('maintenance::inventory.edit', [
            'title' => 'Editing Inventory Item: '.$item->name,
            'item' => $item,
        ]);
    }

    /**
     * Updates the specified inventory.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request, $id)
    {
        $inventory = $this->inventory->update($request, $id);

        if($inventory) {
            $message = 'Successfully updated inventory item.';

            return redirect()->route('maintenance.inventory.show', [$inventory->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this inventory item. Please try again.';

            return redirect()->route('maintenance.inventory.edit', [$id])->withErrors($message);
        }
    }

    /**
     * Removes the specified inventory.
     *
     * @param int|string $id
     *
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
