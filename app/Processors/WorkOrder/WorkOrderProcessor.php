<?php

namespace App\Processors\WorkOrder;

use App\Http\Requests\WorkOrder\WorkOrderRequest;
use App\Http\Presenters\WorkOrder\WorkOrderPresenter;
use App\Models\WorkOrder;
use App\Processors\Processor;

class WorkOrderProcessor extends Processor
{
    /**
     * @var WorkOrder
     */
    protected $workOrder;

    /**
     * @var WorkOrderPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param WorkOrder $workOrder
     * @param WorkOrderPresenter $presenter
     */
    public function __construct(WorkOrder $workOrder, WorkOrderPresenter $presenter)
    {
        $this->workOrder = $workOrder;
        $this->presenter = $presenter;
    }

    /**
     * Displays all work orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $workOrders = $this->presenter->table($this->workOrder);

        $navbar = $this->presenter->navbar();

        return view('work-orders.index', compact('workOrders', 'navbar'));
    }

    /**
     * Displays the form to create a work order.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->workOrder);

        return view('work-orders.create', compact('form'));
    }

    /**
     * Creates a new work order.
     *
     * @param WorkOrderRequest $request
     *
     * @return bool
     */
    public function store(WorkOrderRequest $request)
    {
        $workOrder = $this->workOrder->newInstance();

        $workOrder->user_id = auth()->id();
        $workOrder->category_id = $request->input('category');
        $workOrder->location_id = $request->input('location');
        $workOrder->status_id = $request->input('status');
        $workOrder->priority_id = $request->input('priority');
        $workOrder->subject = $request->input('subject');
        $workOrder->description = $request->clean($request->input('description'));
        $workOrder->started_at = $request->input('started_at');
        $workOrder->completed_at = $request->input('completed_at');

        if ($workOrder->save()) {
            $assets = $request->input('assets', []);

            if (is_array($assets) && count($assets) > 0) {
                $workOrder->assets()->sync($assets);
            }

            return true;
        }

        return false;
    }

    /**
     * Displays the specified work order.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $workOrder = $this->workOrder->findOrFail($id);

        $sessions = $workOrder->getUniqueSessions();

        return view('work-orders.show', compact('workOrder', 'sessions'));
    }

    /**
     * Displays the form for editing the specified work order.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $workOrder = $this->workOrder->findOrFail($id);

        $form = $this->presenter->form($workOrder);

        return view('work-orders.edit', compact('form'));
    }

    /**
     * Updates the specified work order.
     *
     * @param WorkOrderRequest $request
     * @param int|string       $id
     *
     * @return bool
     */
    public function update(WorkOrderRequest $request, $id)
    {
        $workOrder = $this->workOrder->findOrFail($id);

        $workOrder->category_id = $request->input('category');
        $workOrder->location_id = $request->input('location');
        $workOrder->status_id = $request->input('status');
        $workOrder->priority_id = $request->input('priority');
        $workOrder->subject = $request->input('subject');
        $workOrder->description = $request->clean($request->input('description'));
        $workOrder->started_at = $request->input('started_at');
        $workOrder->completed_at = $request->input('completed_at');

        if ($workOrder->save()) {
            $assets = $request->input('assets', []);

            if (is_array($assets) && count($assets) > 0) {
                $workOrder->assets()->sync($assets);
            }

            return true;
        }

        return false;
    }

    /**
     * Deletes the specified work order.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $workOrder = $this->workOrder->findOrFail($id);

        return $workOrder->delete();
    }
}
