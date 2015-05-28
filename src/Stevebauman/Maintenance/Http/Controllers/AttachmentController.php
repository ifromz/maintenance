<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\StorageService;
use Stevebauman\Maintenance\Services\AttachmentService;

/**
 * Class AttachmentController.
 */
class AttachmentController extends BaseController
{
    /**
     * @var AttachmentService
     */
    protected $attachment;

    /**
     * @var StorageService
     */
    protected $storage;

    /**
     * Constructor.
     *
     * @param AttachmentService $attachment
     * @param StorageService    $storage
     */
    public function __construct(AttachmentService $attachment, StorageService $storage)
    {
        $this->attachment = $attachment;
        $this->storage = $storage;
    }

    /**
     * Deletes the attachment with the specified ID.
     *
     * @param int|string $attachmentId
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($attachmentId)
    {
        $attachment = $this->attachment->find($attachmentId);

        if ($this->storage->delete($attachment->file_path.$attachment->file_name)) {
            $this->storage->deleteDirectory($attachment->file_path);

            if ($attachment->delete()) {
                $this->message = 'Successfully deleted attachment';
                $this->messageType = 'success';
            }
        }

        $this->message = 'There was an issue deleting this attachment. Please try again.';
        $this->messageType = 'danger';

        return $this->response();
    }
}
