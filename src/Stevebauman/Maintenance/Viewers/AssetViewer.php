<?php

namespace Stevebauman\Maintenance\Viewers;

class AssetViewer extends BaseViewer
{
    public function profile()
    {
        return view('maintenance::viewers.asset.profile', ['asset' => $this->entity]);
    }

    public function slideshow()
    {
        return view('maintenance::viewers.asset.slideshow', ['asset' => $this->entity]);
    }

    public function meters()
    {
        return view('maintenance::viewers.asset.meters', ['asset' => $this->entity]);
    }

    public function calendar()
    {
        return view('maintenance::viewers.asset.calendar', ['asset' => $this->entity]);
    }

    public function manuals()
    {
        return view('maintenance::viewers.asset.manuals', ['asset' => $this->entity]);
    }

    public function workOrders($workOrders)
    {
        return view('maintenance::viewers.asset.work-orders', ['workOrders' => $workOrders]);
    }

    public function btnEvents()
    {
        return view('maintenance::viewers.asset.buttons.events', ['asset' => $this->entity]);
    }

    public function btnAddImages()
    {
        return view('maintenance::viewers.asset.buttons.add-images', ['asset' => $this->entity]);
    }

    public function btnViewImages()
    {
        return view('maintenance::viewers.asset.buttons.view-images', ['asset' => $this->entity]);
    }

    public function btnAddManuals()
    {
        return view('maintenance::viewers.asset.buttons.add-manuals', ['asset' => $this->entity]);
    }

    public function btnAddMeter()
    {
        return view('maintenance::viewers.asset.buttons.add-meter', ['asset' => $this->entity]);
    }

    public function btnEdit()
    {
        return view('maintenance::viewers.asset.buttons.edit', ['asset' => $this->entity]);
    }

    public function btnDelete()
    {
        return view('maintenance::viewers.asset.buttons.delete', ['asset' => $this->entity]);
    }

    public function btnRestore()
    {
        return view('maintenance::viewers.asset.buttons.restore', ['asset' => $this->entity]);
    }

    public function btnQrCode()
    {
        return view('maintenance::viewers.partials.buttons.qr-code', [
            'id' => 'qr-modal',
            'title' => 'QR Code',
            'content' => route('maintenance.assets.show', [$this->entity->id]),
        ]);
    }

    public function btnActions()
    {
        return view('maintenance::viewers.asset.buttons.actions', ['asset' => $this->entity]);
    }

    public function btnActionsArchive()
    {
        return view('maintenance::viewers.asset.buttons.actions-archived', ['asset' => $this->entity]);
    }

    public function btnEventTag()
    {
        return view('maintenance::viewers.asset.buttons.event-tag', [
            'asset' => $this->entity,
        ]);
    }
}
