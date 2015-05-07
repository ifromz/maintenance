<?php

namespace Stevebauman\Maintenance\Viewers;

class MeterViewer extends BaseViewer
{
    public function btnActions()
    {
        return view('maintenance::viewers.meter.buttons.actions', ['meter' => $this->entity]);
    }

    public function btnEditForAsset($asset)
    {
        return view('maintenance::viewers.meter.buttons.edit-asset', ['asset' => $asset, 'meter' => $this->entity]);
    }

    public function btnDeleteForAsset($asset)
    {
        return view('maintenance::viewers.meter.buttons.delete-asset', ['asset' => $asset, 'meter' => $this->entity]);
    }

    public function btnActionsForAsset($asset)
    {
        return view('maintenance::viewers.meter.buttons.actions-asset', ['asset' => $asset, 'meter' => $this->entity]);
    }
}
