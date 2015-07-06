<?php

namespace Stevebauman\Maintenance\Http\Controllers\Inventory;

use Stevebauman\Maintenance\Http\Requests\NoteRequest;
use Stevebauman\Maintenance\Repositories\Inventory\Repository as InventoryRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class NoteController extends BaseController
{
    /**
     * @var InventoryRepository
     */
    protected $inventory;

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
     * Displays the form for creating a new inventory note.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $item = $this->inventory->find($id);

        return view('maintenance::inventory.notes.create', compact('item'));
    }

    public function store(NoteRequest $request, $id)
    {

    }

    public function show($id, $noteId)
    {

    }

    public function edit($id, $noteId)
    {

    }

    public function update($id, $noteId)
    {

    }

    public function destroy($id, $noteId)
    {

    }
}
