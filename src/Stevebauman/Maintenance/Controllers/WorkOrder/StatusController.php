<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\StatusValidator;
use Stevebauman\Maintenance\Services\StatusService;
use Stevebauman\Maintenance\Controllers\BaseController;

class StatusController extends BaseController
{
    /**
     * @var StatusService
     */
    protected $status;

    /**
     * @var StatusValidator
     */
    protected $statusValidator;

    /**
     * Constructor.
     *
     * @param StatusService $status
     *
     * @param StatusValidator $statusValidator
     */
    public function __construct(StatusService $status, StatusValidator $statusValidator)
    {
        $this->status = $status;
        $this->statusValidator = $statusValidator;
    }

    /**
     * Displays all of the work order statuses.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $statuses = $this->status->get();

        return view('maintenance::work-orders.statuses.index', [
            'title' => 'All Statuses',
            'statuses' => $statuses
        ]);
    }

    /**
     * Displays the form for creating a new
     * work order status.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::work-orders.statuses.create', [
            'title' => 'Create a Status'
        ]);
    }

    /**
     * Creates a new work order status.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        /*
         * Make sure the inputted status name is unique
         */
        $this->statusValidator->unique('name', 'statuses', 'name');

        if ($this->statusValidator->passes()) {
            if ($this->status->setInput($this->inputAll())->create()) {
                $this->message = 'Successfully created status';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.statuses.index');
            } else {
                $this->message = 'There was an error trying to create a status. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.statuses.create');
            }
        } else {
            $this->errors = $this->statusValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.statuses.create');
        }

        return $this->response();
    }

    /**
     * Displays the form for editing a
     * work order status.
     *
     * @param string|int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $status = $this->status->find($id);

        return view('maintenance::work-orders.statuses.edit', [
            'title' => 'Editing Status: ' . $status->name,
            'status' => $status
        ]);
    }

    /**
     * Updates the specified work order status.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        /*
         * Ignores the current status ID but makes
         *  sure the name is still unique
         */
        $this->statusValidator->ignore('name', 'statuses', 'name', $id);

        if ($this->statusValidator->passes()) {
            if ($this->status->setInput($this->inputAll())->update($id)) {
                $this->message = 'Successfully updated status';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.statuses.index');
            } else {
                $this->message = 'There was an error trying to update this status. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.statuses.edit', [$id]);
            }
        } else {
            $this->errors = $this->statusValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.statuses.edit', [$id]);
        }

        return $this->response();
    }

    /**
     * Deletes the specified work order status.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->status->destroy($id);

        $this->message = 'Successfully deleted status';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.work-orders.statuses.index');

        return $this->response();
    }
}
