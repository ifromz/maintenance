<?php

namespace Stevebauman\Maintenance\Viewers\Inventory;

use Stevebauman\Maintenance\Viewers\BaseViewer;

class InventoryViewer extends BaseViewer
{
    public function profile()
    {
        return view('maintenance::viewers.inventory.profile', ['item' => $this->entity]);
    }

    public function calendar()
    {
        return view('maintenance::viewers.inventory.calendar', ['item' => $this->entity]);
    }

    public function stock()
    {
        return view('maintenance::viewers.inventory.stock', ['item' => $this->entity]);
    }

    public function notes()
    {
        return view('maintenance::viewers.inventory.notes', ['item' => $this->entity]);
    }

    public function btnAddNote()
    {
        return view('maintenance::viewers.inventory.buttons.add-note', ['item' => $this->entity]);
    }

    public function btnAddStock()
    {
        return view('maintenance::viewers.inventory.buttons.add-stock', ['item' => $this->entity]);
    }

    public function btnRegenerateSku()
    {
        return view('maintenance::viewers.inventory.buttons.regenerate-sku', ['item' => $this->entity]);
    }

    public function btnQrCode()
    {
        return view('maintenance::viewers.partials.buttons.qr-code', [
            'id' => 'qr-modal',
            'title' => 'QR Code',
            'content' => route('maintenance.inventory.show', [$this->entity->id]),
        ]);
    }

    public function btnEvents()
    {
        return view('maintenance::viewers.inventory.buttons.events', ['item' => $this->entity]);
    }

    public function btnEdit()
    {
        return view('maintenance::viewers.inventory.buttons.edit', ['item' => $this->entity]);
    }

    public function btnDelete()
    {
        return view('maintenance::viewers.inventory.buttons.delete', ['item' => $this->entity]);
    }

    public function btnActions()
    {
        return view('maintenance::viewers.inventory.buttons.actions', ['item' => $this->entity]);
    }

    public function btnSelectForWorkOrder($workOrder)
    {
        return view('maintenance::viewers.inventory.buttons.select-work-order', [
            'workOrder' => $workOrder,
            'item' => $this->entity,
        ]);
    }

    public function btnEventTag()
    {
        return view('maintenance::viewers.inventory.buttons.event-tag', [
            'item' => $this->entity,
        ]);
    }

    public function btnNoteActions($note)
    {
        return view('maintenance::viewers.inventory.buttons.note-actions', [
            'item' => $this->entity,
            'note' => $note,
        ]);
    }
}
