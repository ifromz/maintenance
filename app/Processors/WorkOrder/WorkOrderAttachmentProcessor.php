<?php

namespace App\Processors\WorkOrder;

use App\Http\Presenters\WorkOrder\WorkOrderAttachmentPresenter;
use App\Http\Requests\AttachmentRequest;
use App\Jobs\StoreAttachment;
use App\Models\WorkOrder;
use App\Processors\Processor;

class WorkOrderAttachmentProcessor extends Processor
{
    /**
     * @var WorkOrder
     */
    protected $workOrder;

    /**
     * @var WorkOrderAttachmentPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param WorkOrder $workOrder
     * @param WorkOrderAttachmentPresenter $presenter
     */
    public function __construct(WorkOrder $workOrder, WorkOrderAttachmentPresenter $presenter)
    {
        $this->workOrder = $workOrder;
        $this->presenter = $presenter;
    }

    /**
     * Displays all of the specified work orders attachments.
     *
     * @param int|string $workOrderId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId)
    {
        $workOrder = $this->workOrder->findOrFail($workOrderId);

        $attachments = $this->presenter->table($workOrder);

        return view('work-orders.attachments.index', compact('attachments'));
    }

    public function create($workOrderId)
    {
        $workOrder = $this->workOrder->findOrFail($workOrderId);

        $form = $this->presenter->form($workOrder, $workOrder->attachments()->getRelated());

        return view('work-orders.attachments.create', compact('form'));
    }

    public function store(AttachmentRequest $request, $workOrderId)
    {
        $workOrder = $this->workOrder->findOrFail($workOrderId);

        return $this->dispatch(new StoreAttachment($request, $workOrder->attachments()));
    }
}
