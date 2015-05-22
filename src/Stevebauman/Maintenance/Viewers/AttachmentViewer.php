<?php

namespace Stevebauman\Maintenance\Viewers;

class AttachmentViewer extends BaseViewer
{
    public function tagImage()
    {
        return view('maintenance::viewers.attachments.tags.image', [
            'image' => $this->entity,
        ]);
    }

    public function tagImageThumbnail()
    {
        return view('maintenance::viewers.attachments.tags.image-thumbnail', [
            'image' => $this->entity,
        ]);
    }

    public function btnActionsForWorkOrderAttachment($workOrder)
    {
        return view('maintenance::viewers.attachments.buttons.actions-work-order-attachment', [
            'workOrder' => $workOrder,
            'attachment' => $this->entity,
        ]);
    }

    public function btnActionsForAssetManual($asset)
    {
        return view('maintenance::viewers.attachments.buttons.actions-asset-manual', [
            'asset' => $asset,
            'manual' => $this->entity,
        ]);
    }

    public function btnActionsForAssetImage($asset)
    {
        return view('maintenance::viewers.attachments.buttons.actions-asset-image', [
            'asset' => $asset,
            'image' => $this->entity,
        ]);
    }
}
