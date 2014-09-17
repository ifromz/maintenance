<?php namespace Stevebauman\Maintenance\Requests;

use Illuminate\Support\Facades\View;
use Stevebauman\Maintenance\Validators\WorkOrderValidator;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Requests\AbstractRequest;
use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;

class WorkOrderRequest extends AbstractRequest {
        
        public function __construct(
                WorkOrderService $workOrder, 
                WorkOrderValidator $workOrderValidator){
            $this->workOrder = $workOrder;
            $this->workOrderValidator = $workOrderValidator;
        }
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($data = NULL){
            $workOrders = $this->workOrder->getByPageWithFilter($data);
            
            return View::make('maintenance::work-orders.index', array(
                'title' => 'Work Orders',
                'workOrders' => $workOrders
            ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
            
            return View::make('maintenance::work-orders.create', array(
                'title' => 'Create a Work Order'
            ));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($data){
            $validator = new $this->workOrderValidator;
		
            if($validator->passes()){
                $workOrder = $this->workOrder->create($data);

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
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id){
            try{
                $workOrder = $this->workOrder->find($id);

                return View::make('maintenance::work-orders.show', 
                    array(
                        'title' => 'Viewing Work Order: '.$workOrder->subject,
                        'workOrder' => $workOrder
                    )
                );

            } catch(RecordNotFoundException $e){
                return $this->workOrderNotFound();
            }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id){
            try{
                $workOrder = $this->workOrder->with('category')->find($id);
                
                $dateFormat = 'Y/m/d';
                $timeFormat = 'H:i A';

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
                
                return View::make('maintenance::work-orders.edit', array(
                    'title' => 'Editing Work Order: '.$workOrder->subject,
                    'workOrder' => $workOrder,
                    'dates' => $dates,
                ));
                
            } catch (RecordNotFoundException $e) {
                return $this->workOrderNotFound();
            }
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, $data){
            
            $validator = new $this->workOrderValidator;
		
		if($validator->passes()){
		
                    try {
                        $record = $this->workOrder->update($id, $data);

                        $this->redirect = route('maintenance.work-orders.show', array($id));
                        $this->message = sprintf('Successfully edited work order. %s', link_to_route('maintenance.work-orders.show', 'Show', array($record->id)));
                        $this->messageType = 'success';
                        
                    } catch(RecordNotFoundException $e){
                        return $this->workOrderNotFound();
                    }
		} else{
                    $this->errors = $validator->getErrors();
		}
                
                return $this->response();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id){
            try{
                if($this->workOrder->destroy($id)){
                    $this->message = 'Successfully deleted work order';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.work-orders.index');
                } else{
                    $this->message = 'There was an error deleting the work order. Please try again';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.work-orders.show', array($id));
                }
            } catch(RecordNotFoundException $e){
                return $this->workOrderNotFound();
            }
            
            return $this->response();
	}
        
        public function workOrderNotFound(){
            $this->redirect = route('maintenance.work-orders.index');
            $this->message = 'Work order not found; It either does not exist, or has been deleted';
            $this->messageType = 'danger';
            
            return $this->response();
        }


}
