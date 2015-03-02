<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder\Attachment;

use Stevebauman\Maintenance\Services\StorageService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Services\WorkOrder\AttachmentService as WorkOrderAttachmentService;
use Stevebauman\Maintenance\Services\AttachmentService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class AttachmentController
 * @package Stevebauman\Maintenance\Controllers\WorkOrder\Attachment
 */
class AttachmentController extends BaseController
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
     * @var StorageService
     */
    protected $storage;

    /**
     * @param WorkOrderService $workOrder
     * @param WorkOrderAttachmentService $workOrderAttachment
     * @param AttachmentService $attachment
     * @param StorageService $storage
     */
    public function __construct(
        WorkOrderService $workOrder,
        WorkOrderAttachmentService $workOrderAttachment,
        AttachmentService $attachment,
        StorageService $storage
    )
    {
        $this->workOrder = $workOrder;
        $this->workOrderAttachment = $workOrderAttachment;
        $this->attachment = $attachment;
        $this->storage = $storage;
    }

    /**
     * Displays a list of the work order attachments
     *
     * @param $workOrder_id
     * @return mixed
     */
    public function index($workOrder_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);

        return view('maintenance::work-orders.attachments.index', array(
            'title' => 'Work Order Attachments',
            'workOrder' => $workOrder
        ));
    }

    /**
     * Displays the form to create work order attachments
     *
     * @param $workOrder_id
     * @return mixed
     */
    public function create($workOrder_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);

        return view('maintenance::work-orders.attachments.create', array(
            'title' => 'Add Attachments to Work Order',
            'workOrder' => $workOrder
        ));
    }

    /**
     * Processes storing the attachment record
     *
     * @param $workOrder_id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($workOrder_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);

        $data = $this->inputAll();
        $data['work_order_id'] = $workOrder->id;

        if ($this->workOrderAttachment->setInput($data)->create())
        {
            $this->redirect = route('maintenance.work-orders.attachments.index', array($workOrder->id));
            $this->message = 'Successfully added attachments';
            $this->messageType = 'success';
        } else
        {
            $this->redirect = route('maintenance.work-orders.attachments.create', array($workOrder->id));
            $this->message = 'There was an error adding images to the asset, please try again';
            $this->messageType = 'danger';
        }

        return $this->response();
    }

    /**
     * Processes deleting an attachment record and the file itself
     *
     * @param $workOrder_id
     * @param $attachment_id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function destroy($workOrder_id, $attachment_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);
        $attachment = $this->attachment->find($attachment_id);

        if ($this->storage->delete($attachment->file_path . $attachment->file_name))
        {
            /*
             * We'll try and remove the directory if it's empty
             */
            $this->storage->deleteDirectory($attachment->file_path);

            $attachment->delete();

            $this->redirect = route('maintenance.work-orders.attachments.index', array($workOrder->id));
            $this->message = 'Successfully deleted attachment';
            $this->messageType = 'success';
        } else
        {
            $this->redirect = route('maintenance.work-orders.attachments.index', array($workOrder->id));
            $this->message = 'There was an error deleting the attached file, please try again';
            $this->messageType = 'danger';
        }

        return $this->response();

    }

}