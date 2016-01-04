<?php

namespace App\Repositories\WorkOrder;

use App\Repositories\AttachmentRepository as BaseAttachmentRepository;

class AttachmentRepository extends BaseAttachmentRepository
{
    /**
     * The directory to store uploaded files for work orders.
     *
     * @var string
     */
    protected $uploadDir = 'work-orders'.DIRECTORY_SEPARATOR.'attachments';
}
