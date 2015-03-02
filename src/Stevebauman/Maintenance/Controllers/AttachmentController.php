<?php 

namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Stevebauman\Maintenance\Services\StorageService;
use Stevebauman\Maintenance\Services\AttachmentService;

/**
 * Class AttachmentController
 * @package Stevebauman\Maintenance\Controllers
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
     * @param AttachmentService $attachment
     * @param StorageService $storage
     */
	public function __construct(AttachmentService $attachment, StorageService $storage)
    {
		$this->attachment = $attachment;
        $this->storage = $storage;
	}

    /**
     * Deletes the attachment with the specified ID
     *
     * @param $attachment_id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
	public function destroy($attachment_id)
    {
        $attachment = $this->attachment->find($attachment_id);

        if($attachment)
        {
            if ($this->storage->delete($attachment->file_path . $attachment->file_name)) {
                $this->storage->deleteDirectory($attachment->file_path);
                //rmdir($this->config->get('path.storage').$attachment->file_path);
                $attachment->delete();

                $this->message = 'Successfully deleted attachment';
                $this->messageType = 'success';

            } else {
                $this->message = 'Error deleting attachment';
                $this->messageType = 'error';
            }

            return $this->response();
        }
	}
}