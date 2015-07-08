<?php

namespace Stevebauman\Maintenance\Repositories\WorkOrder;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Stevebauman\Maintenance\Models\WorkOrder;
use Stevebauman\Maintenance\Http\Requests\WorkOrder\AttachmentUpdateRequest;
use Stevebauman\Maintenance\Http\Requests\AttachmentRequest;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Repositories\AttachmentRepository as BaseAttachmentRepository;

class AttachmentRepository extends BaseAttachmentRepository
{
    /**
     * The directory to store uploaded files for work orders.
     *
     * @var string
     */
    protected $workOrderDir = 'work-orders';

    /**
     * Constructor.
     *
     * @param SentryService $sentry
     * @param Storage       $storage
     */
    public function __construct(SentryService $sentry, Storage $storage)
    {
        $this->sentry = $sentry;
        $this->storage = $storage->disk($this->model()->getDisk());
    }

    /**
     * Uploads the request files for the specified ticket.
     *
     * @param AttachmentRequest $request
     * @param WorkOrder         $workOrder
     *
     * @return array
     */
    public function uploadForWorkOrder(AttachmentRequest $request, WorkOrder $workOrder)
    {
        $uploads = [];

        if($request->hasFile('files')) {
            foreach($request->file('files') as $file) {
                if($file instanceof UploadedFile) {
                    $upload = $this->createForWorkOrder($workOrder, $file);

                    if($upload) {
                        $uploads[] = $upload;
                    }
                }
            }
        }

        if(count($uploads) > 0) {
            return $uploads;
        }

        return false;
    }

    /**
     * Creates an upload record for the specified ticket and uploaded file.
     *
     * @param WorkOrder    $workOrder
     * @param UploadedFile $file
     *
     * @return \Stevebauman\Maintenance\Models\Attachment|bool
     */
    public function createForWorkOrder(WorkOrder $workOrder, UploadedFile $file)
    {
        $path = $this->getWorkOrderUploadPath($workOrder->getKey());

        $fileName = $this->getUniqueFileName($file);

        $storePath = $path.DIRECTORY_SEPARATOR.$fileName;

        $realPath = $file->getRealPath();

        $contents = ($realPath ? file_get_contents($realPath) : false);

        if($contents && $this->storage->put($storePath, $contents)) {
            $attributes = [
                'user_id' => $this->sentry->getCurrentUserId(),
                'name' => $file->getClientOriginalName(),
                'file_path' => $storePath,
            ];

            $attachment = $workOrder->attachments()->create($attributes);

            if($attachment) {
                return $attachment;
            }
        }

        return false;
    }

    /**
     * Updates an upload record for the specified ticket.
     *
     * @param AttachmentUpdateRequest $request
     * @param WorkOrder               $workOrder
     * @param int|string              $id
     *
     * @return \Stevebauman\Maintenance\Models\Attachment|bool
     */
    public function updateForWorkOrder(AttachmentUpdateRequest $request, WorkOrder $workOrder, $id)
    {
        $attachment = $workOrder->attachments()->find($id);

        if($attachment) {
            $attachment->name = $request->input('name', $attachment->name);

            if($attachment->save()) {
                return $attachment;
            }
        }

        return false;
    }

    /**
     * Returns the complete upload path for
     * storing uploaded files attached to work orders.
     *
     * @param string $append
     *
     * @return string
     */
    public function getWorkOrderUploadPath($append = null)
    {
        $path = $this->appendPath($this->workOrderDir, $append);

        return $this->getUploadPath($path);
    }
}
