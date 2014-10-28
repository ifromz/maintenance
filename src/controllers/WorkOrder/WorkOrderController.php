<?php 

namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\WorkOrderValidator;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\AbstractController;

class WorkOrderController extends AbstractController {
        
        public function __construct(WorkOrderService $workOrder, WorkOrderValidator $workOrderValidator){
            $this->workOrder = $workOrder;
            $this->workOrderValidator = $workOrderValidator;
        }
        
	/**
	 * Displays all work orders (paginated with search functionality)
	 *
	 * @return Response
	 */
	public function index(){
            $workOrders = $this->workOrder->setInput($this->inputAll())->getByPageWithFilter();
            
            return $this->view('maintenance::work-orders.index', array(
                'title' => 'Work Orders',
                'workOrders' => $workOrders
            ));
	}


	/**
	 * Displays the form to create a work order
	 *
	 * @return Response
	 */
	public function create(){
            
            return $this->view('maintenance::work-orders.create', array(
                'title' => 'Create a Work Order'
            ));
	}


	/**
	 * Stores a new work order
	 *
	 * @return Response
	 */
	public function store(){
            $validator = new $this->workOrderValidator;
            
            if($validator->passes()){
                $workOrder = $this->workOrder->setInput($this->inputAll())->create();

                $this->redirect = route('maintenance.work-orders.index');
                $this->message = sprintf('Successfully created work order. %s', link_to_route('maintenance.work-orders.show', 'Show', array($workOrder->id)));
                $this->messageType = 'success';
            } else{
                $this->redirect = route('maintenance.work-orders.create');
                $this->errors = $validator->getErrors();
            }
            
            return $this->response();
	}


	/**
	 * Displays the specified work order
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
            $workOrder = $this->workOrder->find($id);

            return $this->view('maintenance::work-orders.show', 
                array(
                    'title' => 'Viewing Work Order: '.$workOrder->subject,
                    'workOrder' => $workOrder
                )
            );
	}


	/**
	 * Displays the edit form for the specified work order
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){

            $workOrder = $this->workOrder->with('category')->find($id);
            
            /*
             * Set date/time format fields (in sync with javascript setup)
             */
            $dateFormat = 'd F, Y';
            $timeFormat = 'H:i A';
            
            /*
             * Convert record dates for editing pickatime/pickadate fields
             */
            $dates = array(
                    'started'=>array(
                            'date'=>($workOrder->started_at ? date($dateFormat, strtotime($workOrder->started_at)) : NULL),
                            'time'=>($workOrder->started_at ? date($timeFormat, strtotime($workOrder->started_at)) : NULL),
                    ),
                    'completed'=>array(
                            'date'=>($workOrder->completed_at ? date($dateFormat, strtotime($workOrder->completed_at)) : NULL),
                            'time'=>($workOrder->completed_at ? date($timeFormat, strtotime($workOrder->completed_at)) : NULL),
                    ),
            );

            return $this->view('maintenance::work-orders.edit', array(
                'title' => 'Editing Work Order: '.$workOrder->subject,
                'workOrder' => $workOrder,
                'dates' => $dates,
            ));
                
	}

	/**
	 * Update the specified work order
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id){
            
            $validator = new $this->workOrderValidator;
		
		if($validator->passes()){

                    $record = $this->workOrder->setInput($this->inputAll())->update($id);

                    $this->redirect = route('maintenance.work-orders.show', array($id));
                    $this->message = sprintf('Successfully edited work order. %s', link_to_route('maintenance.work-orders.show', 'Show', array($record->id)));
                    $this->messageType = 'success';
                        

		} else{
                    $this->errors = $validator->getErrors();
		}
                
                return $this->response();
	}

	/**
	 * Removes the work order
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){

            if($this->workOrder->destroy($id)){
                $this->message = 'Successfully deleted work order';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.index');
            } else{
                $this->message = 'There was an error deleting the work order. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.show', array($id));
            }

            return $this->response();
	}


}
