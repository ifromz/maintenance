<?php

namespace Stevebauman\Maintenance\Models;

/**
 * Class Attachment.
 */
class Attachment extends BaseModel
{
    protected $table = 'attachments';

    protected $viewer = 'Stevebauman\Maintenance\Viewers\AttachmentViewer';

    protected $fillable = ['user_id', 'name', 'file_name', 'file_path'];
}
