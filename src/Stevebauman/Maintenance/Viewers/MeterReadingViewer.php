<?php

namespace Stevebauman\Maintenance\Viewers;

class MeterReadingViewer extends BaseViewer
{
    public function btnActionsForAsset($asset)
    {
        return view('maintenance::viewers.meter.reading.buttons.actions', array(
            'asset' => $asset,
            'reading'=>$this->entity
        ));
    }
}