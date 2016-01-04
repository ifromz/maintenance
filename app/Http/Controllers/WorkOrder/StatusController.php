<?php

namespace App\Http\Controllers\WorkOrder;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\WorkOrder\StatusRequest;
use App\Repositories\WorkOrder\StatusRepository;

class StatusController extends BaseController
{
    /**
     * @var StatusRepository
     */
    protected $status;

    /**
     * @param StatusRepository $status
     */
    public function __construct(StatusRepository $status)
    {
        $this->status = $status;
    }

    /**
     * Displays all of the work order statuses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('work-orders.statuses.index');
    }

    /**
     * Displays the form for creating a new
     * work order status.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('work-orders.statuses.create');
    }

    /**
     * Creates a new work order status.
     *
     * @param StatusRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StatusRequest $request)
    {
        $status = $this->status->create($request);

        if ($status) {
            $message = 'Successfully created status.';

            return redirect()->route('maintenance.work-orders.statuses.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating this status. Please try again.';

            return redirect()->route('maintenance.work-orders.statuses.create')->withErrors($message);
        }
    }

    /**
     * Displays the form for editing a
     * work order status.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $status = $this->status->find($id);

        return view('work-orders.statuses.edit', compact('status'));
    }

    /**
     * Updates the specified work order status.
     *
     * @param StatusRequest $request
     * @param int|string    $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StatusRequest $request, $id)
    {
        $status = $this->status->update($request, $id);

        if ($status) {
            $message = 'Successfully updated status.';

            return redirect()->route('maintenance.work-orders.statuses.index')->withSuccess($message);
        } else {
            $message = 'There was an issue updating this status. Please try again.';

            return redirect()->route('maintenance.work-orders.statuses.edit', [$id])->withErrors($message);
        }
    }

    /**
     * Deletes the specified work order status.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->status->delete($id)) {
            $message = 'Successfully deleted status.';

            return redirect()->route('maintenance.work-orders.statuses.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this status. Please try again.';

            return redirect()->route('maintenance.work-orders.statuses.index', [$id])->withErrors($message);
        }
    }
}
