<?php

namespace Stevebauman\Maintenance\Repositories\Asset;

use Stevebauman\Maintenance\Repositories\AttachmentRepository;

class ManualRepository extends AttachmentRepository
{
    /**
     * The directory to store uploaded manuals for assets.
     *
     * @var string
     */
    protected $uploadDir = 'assets'.DIRECTORY_SEPARATOR.'manuals';
}
