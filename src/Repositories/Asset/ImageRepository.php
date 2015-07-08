<?php

namespace Stevebauman\Maintenance\Repositories\Asset;

use Stevebauman\Maintenance\Repositories\AttachmentRepository;

class ImageRepository extends AttachmentRepository
{
    /**
     * The directory to store uploaded images for assets.
     *
     * @var string
     */
    protected $uploadDir = 'assets'.DIRECTORY_SEPARATOR.'images';
}
