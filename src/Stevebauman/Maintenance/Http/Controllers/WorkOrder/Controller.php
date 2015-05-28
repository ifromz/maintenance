<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\WorkOrder\Request;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var Repository
     */
    protected $workOrder;

    /**
     * Constructor.
     *
     * @param Repository $workOrder
     */
    public function __construct(Repository $workOrder)
    {
        $this->workOrder = $workOrder;
    }

    /**
     * Displays work orders paginated.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::work-orders.index');
    }

    /**
     * Displays the form to create a work order.
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::work-orders.create');
    }

    /**
     * Creates a new work order.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        if ($this->workOrderValidator->passes()) {
            $workOrder = $this->workOrder->setInput($this->inputAll())->create();

            $this->redirect = route('maintenance.work-orders.index');
            $this->message = sprintf('Successfully created work order. %s', link_to_route('maintenance.work-orders.show', 'Show', [$workOrder->id]));
            $this->messageType = 'success';
        } else {
            $this->redirect = route('maintenance.work-orders.create');
            $this->errors = $this->workOrderValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Displays the specified work order.
     *
     * @param string|int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $workOrder = $this->workOrder->find($id);

        $sessions = $workOrder->getUniqueSessions();

        return view('maintenance::work-orders.show', [
            'title' => 'Viewing Work Order: '.$workOrder->subject,
            'workOrder' => $workOrder,
            'sessions' => $sessions,
        ]);
    }

    /**
     * Displays the edit form for the specified work order.
     *
     * @param string|int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $workOrder = $this->workOrder->find($id);

        return view('maintenance::work-orders.edit', [
            'title' => 'Editing Work Order: '.$workOrder->subject,
            'workOrder' => $workOrder,
        ]);
    }

    /**
     * Updates the specified work order.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        if ($this->workOrderValidator->passes()) {
            $record = $this->workOrder->setInput($this->inputAll())->update($id);

            $this->redirect = route('maintenance.work-orders.show', [$id]);
            $this->message = sprintf('Successfully edited work order. %s', link_to_route('maintenance.work-orders.show', 'Show', [$record->id]));
            $this->messageType = 'success';
        } else {
            $this->redirect = route('maintenance.work-orders.edit', [$id]);
            $this->errors = $this->workOrderValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Deletes a work order.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->workOrder->destroy($id)) {
            $this->message = 'Successfully deleted work order';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.index');
        } else {
            $this->message = 'There was an error deleting the work order. Please try again';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', [$id]);
        }

        return $this->response();
    }
}
