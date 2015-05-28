<?php

namespace Stevebauman\Maintenance\Http\Controllers\Admin\Archive;

use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class WorkOrderController extends BaseController
{
    public function __construct(WorkOrderService $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    public function index()
    {
        $workOrders = $this->workOrder->setInput($this->inputAll())->getByPageWithFilter(true);

        return view('maintenance::admin.archive.work-orders.index', [
            'title' => 'Archived Work Orders',
            'workOrders' => $workOrders,
        ]);
    }

    public function show($id)
    {
        $workOrder = $this->workOrder->findArchived($id);

        return view('maintenance::admin.archive.work-orders.show', [
            'title' => 'Viewing Archived Work Order: '.$workOrder->subject,
            'workOrder' => $workOrder,
        ]);
    }

    public function destroy($id)
    {
        $this->workOrder->destroyArchived($id);

        $this->message = 'Successfully deleted work order';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.admin.archive.work-orders.index');

        return $this->response();
    }

    public function restore($id)
    {
        if ($this->workOrder->restoreArchived($id)) {
            $this->message = sprintf('Successfully restored work order. %s', link_to_route('maintenance.work-orders.show', 'Show', $id));
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.work-orders.index');
        } else {
            $this->message = 'There was an error trying to restore this work order, please try again';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.admin.archive.work-orders.index');
        }

        return $this->response();
    }
}
