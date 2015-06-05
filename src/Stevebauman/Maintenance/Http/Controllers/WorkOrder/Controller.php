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
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::work-orders.create');
    }

    /**
     * Creates a new work order.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $workOrder = $this->workOrder->create($request);

        if($workOrder) {
            $message = sprintf('Successfully created work order. %s', link_to_route('maintenance.work-orders.show', 'Show', [$workOrder->id]));

            return redirect()->route('maintenance.work-orders.index')->withSuccess($message);
        } else {
            $message = "There was an issue creating this work order. Please try again.";

            return redirect()->route('maintenance.work-orders.index')->withSuccess($message);
        }
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

        return view('maintenance::work-orders.show', compact('workOrder', 'sessions'));
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

        return view('maintenance::work-orders.edit', compact('workOrder'));
    }

    /**
     * Updates the specified work order.
     *
     * @param Request    $request
     * @param string|int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $workOrder = $this->workOrder->update($request, $id);

        if($workOrder) {
            $message = 'Successfully edited work order.';

            return redirect()->route('maintenance.work-orders.show', [$workOrder->id])->withSuccess($message);
        } else {
            $message = "There was an issue updating this work order. Please try again.";

            return redirect()->route('maintenance.work-orders.edit', [$id])->withErrors($message);
        }
    }

    /**
     * Deletes a work order.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if($this->workOrder->delete($id)) {
            $message = "Successfully deleted work order.";

            return redirect()->route('maintenance.work-orders.index')->withSuccess($message);
        } else {
            $message = "There was an issue deleting this work order. Please try again";

            return redirect()->route('maintenance.work-orders.index')->withErrors($message);
        }
    }
}
