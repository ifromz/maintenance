<?php

namespace Stevebauman\Maintenance\Models;

use Dmyers\Storage\Storage;

/**
 * Class Attachment.
 */
class Attachment extends BaseModel
{
    protected $table = 'attachments';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\AttachmentViewer';

    protected $fillable = ['user_id', 'name', 'file_name', 'file_path'];

    /**
     * Returns an html link to the manual.
     *
     * @return string
     */
    public function getManualLinkAttribute()
    {
        return Storage::url($this->attributes['file_path'].$this->attributes['file_name']);
    }
}
