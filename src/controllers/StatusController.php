<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\StatusValidator;
use Stevebauman\Maintenance\Services\StatusService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class StatusController extends AbstractController {
        
        public function __construct(StatusService $status, StatusValidator $statusValidator)
        {
            $this->status = $status;
            $this->statusValidator = $statusValidator;
        }
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $statuses = $this->status->get();
            
            return $this->view('maintenance::work-orders.statuses.index', array(
                'title' => 'All Statuses',
                'statuses' => $statuses
            ));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            return $this->view('maintenance::work-orders.statuses.create', array(
                'title' => 'Create a Status'
            ));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            $validator = new $this->statusValidator;
            
            if($validator->passes()){
                
                if($this->status->setInput($this->inputAll())->create()){
                    $this->message = 'Successfully created status';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.work-orders.statuses.index');
                } else{
                    $this->message = 'There was an error trying to create a status. Please try again';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.work-orders.statuses.create');
                }
                
            } else{
                $this->errors = $validator->getErrors();
                $this->redirect = route('maintenance.work-orders.statuses.create');
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
            $status = $this->status->find($id);
            
            return $this->view('maintenance::work-orders.statuses.edit', array(
                'title' => 'Editing Status: '.$status->name,
                'status' => $status
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
            $validator = new $this->statusValidator;
            
            if($validator->passes()){
                
                if($this->status->setInput($this->inputAll())->update($id)){
                    $this->message = 'Successfully updated status';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.work-orders.statuses.index');
                } else{
                    $this->message = 'There was an error trying to update this status. Please try again';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.work-orders.statuses.edit', array($id));
                }
                
            } else{
                $this->errors = $validator->getErrors();
                $this->redirect = route('maintenance.work-orders.statuses.edit', array($id));
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
            $this->status->destroy($id);
            
            $this->message = 'Successfully deleted status';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.statuses.index');
            
            return $this->response();
	}


}
