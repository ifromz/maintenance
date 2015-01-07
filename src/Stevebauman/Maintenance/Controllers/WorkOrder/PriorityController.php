<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\PriorityValidator;
use Stevebauman\Maintenance\Services\PriorityService;
use Stevebauman\Maintenance\Controllers\BaseController;

class PriorityController extends BaseController {

    public function __construct(PriorityService $priority, PriorityValidator $priorityValidator)
    {
        $this->priority = $priority;
        $this->priorityValidator = $priorityValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('maintenance::work-orders.priorities.create', array(
            'title' => 'Create a Priority'
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->priorityValidator->unique('name', $this->priority->getTableName(), 'name');

        if($this->priorityValidator->passes()){

            if($this->priority->setInput($this->inputAll())->create()){
                $this->message = 'Successfully created priority';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.priorities.index');
            } else{
                $this->message = 'There was an error trying to create a priority. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.priorities.create');
            }

        } else{
            $this->errors = $this->priorityValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.priorities.create');
        }

        return $this->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $priority = $this->priority->find($id);

        return view('maintenance::work-orders.priorities.edit', array(
            'title' => 'Editing Priority: '.$priority->name,
            'priority' => $priority
        ));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $this->priorityValidator->ignore('name', $this->priority->getTableName(), 'name', $id);

        if($this->priorityValidator->passes()) {

            if($this->priority->setInput($this->inputAll())->update($id)){
                $this->message = 'Successfully updated priority';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.priorities.index');
            } else{
                $this->message = 'There was an error trying to create a priority. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.priorities.edit', array($id));
            }

        } else{
            $this->errors = $this->priorityValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.priorities.edit', array($id));
        }

        return $this->response();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
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
