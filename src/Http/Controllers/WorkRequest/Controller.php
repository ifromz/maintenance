<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkRequest;

use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;
use Stevebauman\Maintenance\Http\Requests\WorkRequest\Request;
use Stevebauman\Maintenance\Repositories\WorkRequest\Repository;

class Controller extends BaseController
{
    /**
     * @var Repository
     */
    protected $workRequest;

    /**
     * @param Repository $workRequest
     */
    public function __construct(Repository $workRequest)
    {
        $this->workRequest = $workRequest;
    }

    /**
     * Displays all work requests.
     *
     * @return mixed
     */
    public function index()
    {
        return view('maintenance::work-requests.index');
    }

    /**
     * Displays the form to create a work request.
     *
     * @return mixed
     */
    public function create()
    {
        return view('maintenance::work-requests.create');
    }

    /**
     * Processes creating a work request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $workRequest = $this->workRequest->create($request);

        if ($workRequest) {
            $message = 'Successfully created work request';

            return redirect()->route('maintenance.work-requests.index')->withSuccess($message);
        } else {
            $message = 'There was an issue creating a work request. Please try again.';

            return redirect()->route('maintenance.work-requests.index')->withErrors($message);
        }
    }

    /**
     * Displays a work request by the specified ID.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $workRequest = $this->workRequest->model()->findOrFail($id);

        return view('maintenance::work-requests.show', compact('workRequest'));
    }

    /**
     * Displays the form for editing the work request.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $workRequest = $this->workRequest->model()->findOrFail($id);

        return view('maintenance::work-requests.edit', compact('workRequest'));
    }

    /**
     * Updates the specified work request.
     *
     * @param Request    $request
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $workRequest = $this->workRequest->update($request, $id);

        if ($workRequest) {
            $message = 'Successfully updated work request';

            return redirect()->route('maintenance.work-requests.show', [$workRequest->id])->withSuccess($message);
        } else {
            $message = 'There was an issue updating this work request. Please try again.';

            return redirect()->route('maintenance.work-requests.edit', [$id])->withErrors($message);
        }
    }

    /**
     * Deletes the specified work request.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $workRequest = $this->workRequest->model()->findOrFail($id);

        if ($workRequest->delete()) {
            $message = 'Successfully deleted work request.';

            return redirect()->route('maintenance.work-requests.index')->withSuccess($message);
        } else {
            $message = 'There was an issue deleting this work request. Please try again.';

            return redirect()->route('maintenance.work-requests.show', [$id])->withErrors($message);
        }
    }
}
