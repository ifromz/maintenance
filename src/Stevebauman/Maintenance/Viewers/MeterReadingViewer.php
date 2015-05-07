<?php

namespace Stevebauman\Maintenance\Viewers;

class MeterReadingViewer extends BaseViewer
{
    public function btnActionsForAsset($asset)
    {
        return view('maintenance::viewers.meter.reading.buttons.actions', [
            'asset' => $asset,
            'reading' => $this->entity,
        ]);
    }
}
