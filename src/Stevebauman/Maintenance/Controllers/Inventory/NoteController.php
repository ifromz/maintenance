<?php

namespace Stevebauman\Maintenance\Controllers\Inventory;

use Stevebauman\Maintenance\Validators\NoteValidator;
use Stevebauman\Maintenance\Services\NoteService;
use Stevebauman\Maintenance\Services\Inventory\InventoryService;
use Stevebauman\Maintenance\Controllers\AbstractNoteableController;

/**
 * Class NoteController.
 */
class NoteController extends AbstractNoteableController
{
    /**
     * @param InventoryService $inventory
     * @param NoteService      $note
     * @param NoteValidator    $noteValidator
     */
    public function __construct(InventoryService $inventory, NoteService $note, NoteValidator $noteValidator)
    {
        $this->noteable = $inventory;

        parent::__construct($note, $noteValidator);
    }
}
