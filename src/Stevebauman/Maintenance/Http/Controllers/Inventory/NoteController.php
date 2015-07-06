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

    /**
     * Creates a note for the specified inventory.
     *
     * @param NoteRequest $request
     * @param int|string  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(NoteRequest $request, $id)
    {
        $note = $this->inventory->createNote($request, $id);

        if($note) {
            $message = 'Successfully created note.';

            return redirect()->route('maintenance.inventory.show', [$id])->withSuccess($message);
        } else {
            $message = 'There was an issue creating a note. Please try again.';

            return redirect()->route('maintenance.inventory.notes.create', [$id])->withErrors($message);
        }
    }

    public function show($id, $noteId)
    {

    }

    public function edit($id, $noteId)
    {

    }

    /**
     * Updates the specified note for the specified inventory.
     *
     * @param NoteRequest $request
     * @param int|string  $id
     * @param int|string  $noteId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(NoteRequest $request, $id, $noteId)
    {
        $note = $this->inventory->updateNote($request, $id, $noteId);

        if($note) {
            $message = 'Successfully updated note.';

            return redirect()->route('maintenance.inventory.notes.show', [$id, $noteId])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this note. Please try again.';

            return redirect()->route('maintenance.inventory.notes.update', [$id, $noteId])->withErrors($message);
        }
    }

    /**
     * Deletes the specified note attached to the specified inventory.
     *
     * @param int|string $id
     * @param int|string $noteId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $noteId)
    {
        if($this->inventory->deleteNote($id, $noteId)) {
            $message = 'Successfully updated note.';

            return redirect()->route('maintenance.inventory.show', [$id])->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this note. Please try again.';

            return redirect()->route('maintenance.inventory.notes.show', [$id, $noteId])->withErrors($message);
        }
    }
}
