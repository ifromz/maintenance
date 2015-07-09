<?php

namespace Stevebauman\Maintenance\Http\Requests\Asset;

use Stevebauman\Maintenance\Http\Requests\AttachmentRequest;

class ManualRequest extends AttachmentRequest
{
    /**
     * The mimes to allow for asset manual uploads.
     *
     * @var array
     */
    protected $mimes = [
        'pdf',
        'txt',
        'doc',
        'docx',
        'xlx',
        'xlsx',
        'ppt',
        'pptx',
    ];
}
