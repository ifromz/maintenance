<?php

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\PublicWorkOrderValidator;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class PublicWorkOrderController extends AbstractController {
    
    public function __construct(WorkOrderService $workOrder, PublicWorkOrderValidator $workOrderValidator)
    {
        $this->workOrder = $workOrder;
        $this->workOrderValidator = $workOrderValidator;
    }
    
    public function index()
    {
        $workOrders = $this->workOrder->getByPageByUser();
        
        return $this->view('maintenance::public.work-orders.index', array(
            'title' => 'My Work Requests',
            'workOrders' => $workOrders
        ));
    }
    
    public function create()
    {
        return $this->view('maintenance::public.work-orders.create', array(
            'title' => 'Submit a Work Request'
        ));
    }
    
    public function store()
    {
        $validator = new $this->workOrderValidator;
        
        if($validator->passes()){
            
            $record = $this->workOrder->setInput($this->inputAll())->createRequest();
            
            $this->message = sprintf('Successfully submitted work order request. %s', link_to_route('maintenance.work-requests.show', 'Show', array($record->id)));
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-requests.index');
            
        } else{
            $this->errors = $validator->getErrors();
            $this->redirect = route('maintenance.work-requests.create');
        }
        
        return $this->response();
    }
    
    public function show($id)
    {
        $workOrder = $this->workOrder->find($id);
        
        return $this->view('maintenance::public.work-orders.show', array(
            'title' => 'Viewing Work Request',
            'workOrder' => $workOrder
        ));
    }
    
    public function edit($id)
    {
        $workOrder = $this->workOrder->find($id);
        
        return $this->view('maintenance::public.work-orders.edit', array(
            'title' => 'Editing Work Request',
            'workOrder' => $workOrder
        ));
    }
    
    public function update($id)
    {
        $validator = new $this->workOrderValidator;
        
        if($validator->passes()){
            
            $record = $this->workOrder->setInput($this->inputAll())->updateRequest($id);
            
            $this->message = sprintf('Successfully edited work order request. %s', link_to_route('maintenance.work-requests.show', 'Show', array($record->id)));
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-requests.index');
            
        } else{
            $this->errors = $validator->getErrors();
            $this->redirect = route('maintenance.work-requests.edit');
        }
        
        return $this->response();
    }
    
    public function destroy($id)
    {
        if($this->workOrder->destroyRequest($id)){
            $this->message = 'Successfully deleted work request';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-requests.index');
        } else{
            $this->message = 'There was an error trying to delete your work request. Please try again.';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-requests.index');
        }
        
        return $this->response();
    }
    
}