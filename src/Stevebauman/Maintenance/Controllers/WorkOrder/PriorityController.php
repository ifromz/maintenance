<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\PriorityValidator;
use Stevebauman\Maintenance\Services\PriorityService;
use Stevebauman\Maintenance\Controllers\BaseController;

class PriorityController extends BaseController
{
    /**
     * @var PriorityService
     */
    protected $priority;

    /**
     * @var PriorityValidator
     */
    protected $priorityValidator;

    /**
     * Constructor.
     *
     * @param PriorityService $priority
     * @param PriorityValidator $priorityValidator
     */
    public function __construct(PriorityService $priority, PriorityValidator $priorityValidator)
    {
        $this->priority = $priority;
        $this->priorityValidator = $priorityValidator;
    }

    /**
     * Displays all priorities.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $priorities = $this->priority->get();

        return view('maintenance::work-orders.priorities.index', array(
            'title' => 'All Priorities',
            'priorities' => $priorities
        ));
    }

    /**
     * Displays the form for creating a priority.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('maintenance::work-orders.priorities.create', array(
            'title' => 'Create a Priority'
        ));
    }

    /**
     * Creates a new priority.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->priorityValidator->unique('name', $this->priority->getTableName(), 'name');

        if ($this->priorityValidator->passes()) {
            if ($this->priority->setInput($this->inputAll())->create()) {
                $this->message = 'Successfully created priority';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.priorities.index');
            } else {
                $this->message = 'There was an error trying to create a priority. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.priorities.create');
            }
        } else {
            $this->errors = $this->priorityValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.priorities.create');
        }

        return $this->response();
    }

    /**
     * Displays the form for editing the specified priority.
     *
     * @param string|int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $priority = $this->priority->find($id);

        return view('maintenance::work-orders.priorities.edit', array(
            'title' => 'Editing Priority: ' . $priority->name,
            'priority' => $priority
        ));
    }

    /**
     * Updates the specified priority.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $this->priorityValidator->ignore('name', $this->priority->getTableName(), 'name', $id);

        if ($this->priorityValidator->passes()) {
            if ($this->priority->setInput($this->inputAll())->update($id)) {
                $this->message = 'Successfully updated priority';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.priorities.index');
            } else {
                $this->message = 'There was an error trying to create a priority. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.priorities.edit', array($id));
            }
        } else {
            $this->errors = $this->priorityValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.priorities.edit', array($id));
        }

        return $this->response();
    }

    /**
     * Deletes the specified priority.
     *
     * @param string|int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->priority->destroy($id);

        $this->message = 'Successfully deleted priority';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.work-orders.priorities.index');

        return $this->response();
    }
}
