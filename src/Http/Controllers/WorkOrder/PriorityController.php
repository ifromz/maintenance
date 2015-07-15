<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\WorkOrder\PriorityRequest;
use Stevebauman\Maintenance\Repositories\WorkOrder\PriorityRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class PriorityController extends BaseController
{
    /**
     * @var PriorityRepository
     */
    protected $priority;

    /**
     * @param PriorityRepository $priority
     */
    public function __construct(PriorityRepository $priority)
    {
        $this->priority = $priority;
    }

    /**
     * Displays all priorities.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('maintenance::work-orders.priorities.index');
    }

    /**
     * Displays the form for creating a priority.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::work-orders.priorities.create');
    }

    /**
     * Creates a new priority.
     *
     * @param PriorityRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(PriorityRequest $request)
    {
        $priority = $this->priority->create($request);

        if($priority) {
            $message = 'Successfully created priority.';

            return redirect()->route('maintenance.work-orders.priorities.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating a priority. Please try again.';

            return redirect()->route('maintenance.work-orders.priorities.create')->withErrors($message);
        }
    }

    /**
     * Displays the form for editing the specified priority.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $priority = $this->priority->model()->findOrFail($id);

        return view('maintenance::work-orders.priorities.edit', compact('priority'));
    }

    /**
     * Updates the specified priority.
     *
     * @param PriorityRequest $request
     * @param int|string     $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(PriorityRequest $request, $id)
    {
        $priority = $this->priority->update($request, $id);

        if($priority) {
            $message = 'Successfully updated priority.';

            return redirect()->route('maintenance.work-orders.priorities.index')->withSuccess($message);
        } else {
            $message = 'There was an issue updating this priority. Please try again.';

            return redirect()->route('maintenance.work-orders.priorities.edit', [$id])->withErrors($message);
        }
    }

    /**
     * Deletes the specified priority.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $priority = $this->priority->model()->findOrFail($id);

        if($priority->delete()) {
            $message = 'Successfully deleted priority.';

            return redirect()->route('maintenance.work-orders.priorities.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this priority. Please try again.';

            return redirect()->route('maintenance.work-orders.priorities.index')->withErrors($message);
        }
    }
}
