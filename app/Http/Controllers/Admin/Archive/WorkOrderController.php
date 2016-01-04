<?php

namespace App\Http\Controllers\Admin\Archive;

use App\Http\Controllers\Controller;
use App\Repositories\WorkOrder\Repository as WorkOrderRepository;

class WorkOrderController extends Controller
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * @param WorkOrderRepository $workOrder
     */
    public function __construct(WorkOrderRepository $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Displays all archived work orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.archive.work-orders.index');
    }

    /**
     * Displays the specified archived work order.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $workOrder = $this->workOrder->findArchived($id);

        return view('admin.archive.work-orders.show', compact('workOrder'));
    }

    /**
     * Deletes the specified archived work order.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->workOrder->deleteArchived($id)) {
            $message = 'Successfully deleted work order.';

            return redirect()->route('maintenance.admin.archive.work-orders.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this work order. Please try again.';

            return redirect()->route('maintenance.admin.archive.work-orders.show', [$id])->withErrors($message);
        }
    }

    /**
     * Restores the specified work order.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        if ($this->workOrder->restore($id)) {
            $message = 'Successfully restored work order.';

            return redirect()->route('maintenance.admin.archive.work-orders.index')->withSuccess($message);
        } else {
            $this->message = 'There was an error trying to restore this work order, please try again';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.work-orders.index');
        }

        return $this->response();
    }
}
