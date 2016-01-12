<?php

namespace App\Http\Controllers\WorkOrder;

use App\Http\Requests\AttachmentRequest;
use App\Http\Requests\AttachmentUpdateRequest;
use App\Processors\WorkOrder\WorkOrderAttachmentProcessor;
use App\Http\Controllers\Controller;

class WorkOrderAttachmentController extends Controller
{
    /**
     * @var WorkOrderAttachmentProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param WorkOrderAttachmentProcessor $processor
     */
    public function __construct(WorkOrderAttachmentProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays a list of the work order attachments.
     *
     * @param int|string $workOrderId
     *
     * @return \Illuminate\View\View
     */
    public function index($workOrderId)
    {
        return $this->processor->index($workOrderId);
    }

    /**
     * Displays the form to create work order attachments.
     *
     * @param int|string $workOrderId
     *
     * @return \Illuminate\View\View
     */
    public function create($workOrderId)
    {
        return $this->processor->create($workOrderId);
    }

    /**
     * Processes storing the attachment record.
     *
     * @param AttachmentRequest $request
     * @param int|string        $workOrderId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AttachmentRequest $request, $workOrderId)
    {
        if ($this->processor->store($request, $workOrderId)) {
            $message = 'Successfully uploaded files.';

            return redirect()->route('maintenance.work-orders.attachments.index', [$workOrderId]);
        } else {
            $message = 'There was an issue uploading the files you selected. Please try again.';

            return redirect()->route('maintenance.work-orders.attachments.create', [$workOrderId]);
        }
    }

    /**
     * Displays the uploaded file with it's information.
     *
     * @param int|string $workOrderId
     * @param int|string $attachmentId
     *
     * @return \Illuminate\View\View
     */
    public function show($workOrderId, $attachmentId)
    {
        //
    }

    /**
     * Displays the form for editing an uploaded file.
     *
     * @param int|string $id
     * @param int|string $attachmentId
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, $attachmentId)
    {
        $workOrder = $this->workOrder->find($id);

        $attachment = $workOrder->attachments()->find($attachmentId);

        if ($attachment) {
            return view('work-orders.attachments.edit', compact('workOrder', 'attachment'));
        }

        abort(404);
    }

    /**
     * Updates the specified ticket upload.
     *
     * @param AttachmentUpdateRequest $request
     * @param int|string              $id
     * @param int|string              $attachmentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AttachmentUpdateRequest $request, $id, $attachmentId)
    {
        $workOrder = $this->workOrder->find($id);

        $attachment = $this->attachment->update($request, $workOrder->attachments(), $attachmentId);

        if ($attachment) {
            $message = 'Successfully updated attachment.';

            return redirect()->route('maintenance.work-orders.attachments.show', [$workOrder->id, $attachment->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this attachment. Please try again.';

            return redirect()->route('maintenance.work-orders.attachments.show', [$id, $attachmentId])->withErrors($message);
        }
    }

    /**
     * Processes deleting an attachment record and the file itself.
     *
     * @param int|string $id
     * @param int|string $attachmentId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $attachmentId)
    {
        $workOrder = $this->workOrder->find($id);

        $attachment = $workOrder->attachments()->find($attachmentId);

        if ($attachment && $attachment->delete()) {
            $message = 'Successfully deleted attachment.';

            return redirect()->route('maintenance.work-orders.attachments.index', [$workOrder->id])->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this attachment. Please try again.';

            return redirect()->route('maintenance.work-orders.attachments.show', [$workOrder->id, $attachment->id])->withErrors($message);
        }
    }

    /**
     * Prompts the user to download the specified uploaded file.
     *
     * @param int|string $id
     * @param int|string $attachmentId
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id, $attachmentId)
    {
        $workOrder = $this->workOrder->find($id);

        $attachment = $workOrder->attachments()->find($attachmentId);

        if ($attachment) {
            return response()->download($attachment->download_path);
        }

        abort(404);
    }
}
