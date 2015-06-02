<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Illuminate\Filesystem\Filesystem;
use Stevebauman\Maintenance\Validators\DocumentValidator;
use Stevebauman\Maintenance\Validators\ImageValidator;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\WorkOrder\AttachmentService as WorkOrderAttachmentService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Http\Controllers\AbstractUploadController;

/**
 * Class AttachmentController.
 */
class AttachmentController extends AbstractUploadController
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var WorkOrderAttachmentService
     */
    protected $workOrderAttachment;

    /**
     * @var AttachmentService
     */
    protected $attachment;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var ImageValidator
     */
    protected $imageValidator;

    /**
     * @var DocumentValidator
     */
    protected $documentValidator;

    /**
     * {@inheritDoc}
     */
    protected $fileStorageLocation = 'work-orders/attachments/';

    /**
     * Constructor.
     *
     * @param WorkOrderService           $workOrder
     * @param WorkOrderAttachmentService $workOrderAttachment
     * @param AttachmentService          $attachment
     * @param Filesystem                 $filesystem
     * @param ImageValidator             $imageValidator
     * @param DocumentValidator          $documentValidator
     */
    public function __construct(
        WorkOrderService $workOrder,
        WorkOrderAttachmentService $workOrderAttachment,
        AttachmentService $attachment,
        Filesystem $filesystem,
        ImageValidator $imageValidator,
        DocumentValidator $documentValidator
    ) {
        $this->workOrder = $workOrder;
        $this->workOrderAttachment = $workOrderAttachment;
        $this->attachment = $attachment;
        $this->filesystem = $filesystem;
        $this->imageValidator = $imageValidator;
        $this->documentValidator = $documentValidator;
    }

    /**
     * Displays a list of the work order attachments.
     *
     * @param $workOrder_id
     *
     * @return mixed
     */
    public function index($workOrder_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);

        return view('maintenance::work-orders.attachments.index', [
            'title' => 'Work Order Attachments',
            'workOrder' => $workOrder,
        ]);
    }

    /**
     * Displays the form to create work order attachments.
     *
     * @param $workOrder_id
     *
     * @return mixed
     */
    public function create($workOrder_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);

        return view('maintenance::work-orders.attachments.create', [
            'title' => 'Add Attachments to Work Order',
            'workOrder' => $workOrder,
        ]);
    }

    /**
     * Processes storing the attachment record.
     *
     * @param $workOrderId
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($workOrderId)
    {
        // Validate that the uploaded files are either documents or images
        if($this->imageValidator->passes() OR $this->documentValidator->passes()) {
            $files = $this->uploadFiles();

            $data = $this->inputAll();
            $data['work_order_id'] = $workOrderId;
            $data['file_path'] = $this->getUploadDirectory();
            $data['files'] = $files;

            if ($this->workOrderAttachment->setInput($data)->create()) {
                $this->redirect = route('maintenance.work-orders.attachments.index', [$workOrderId]);
                $this->message = 'Successfully added attachments';
                $this->messageType = 'success';
            } else {
                $this->redirect = route('maintenance.work-orders.attachments.create', [$workOrderId]);
                $this->message = 'There was an error adding images to the asset, please try again';
                $this->messageType = 'danger';
            }
        } else {
            $this->redirect = route('maintenance.work-orders.attachments.create', [$workOrderId]);

            $imageErrors = $this->imageValidator->getErrors();

            $documentErrors = $this->documentValidator->getErrors();

            // We need to merge message bags together if both validators contain errors
            if($imageErrors instanceof \Illuminate\Support\MessageBag && $documentErrors instanceof \Illuminate\Support\MessageBag) {
                $this->errors = $imageErrors->merge($documentErrors);
            }
        }

        return $this->response();
    }

    /**
     * Processes deleting an attachment record and the file itself.
     *
     * @param $workOrder_id
     * @param $attachment_id
     *
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($workOrder_id, $attachment_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);
        $attachment = $this->attachment->find($attachment_id);

        if ($this->filesystem->delete($attachment->file_path)) {

            $attachment->delete();

            $this->redirect = route('maintenance.work-orders.attachments.index', [$workOrder->id]);
            $this->message = 'Successfully deleted attachment';
            $this->messageType = 'success';
        } else {
            $this->redirect = route('maintenance.work-orders.attachments.index', [$workOrder->id]);
            $this->message = 'There was an error deleting the attached file, please try again';
            $this->messageType = 'danger';
        }

        return $this->response();
    }
}
