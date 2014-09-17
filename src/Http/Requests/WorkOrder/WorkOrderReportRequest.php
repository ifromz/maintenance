<?php  namespace Stevebauman\Maintenance\Http\Requests;

use Stevebauman\Maintenance\Exceptions\RecordNotFoundException;
use Stevebauman\Maintenance\Validators\WorkOrderReportValidator;
use Stevebauman\Maintenance\Services\WorkOrderReportService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Http\Requests\AbstractRequest;

class WorkOrderReportRequest extends AbstractRequest {
        
        public function __construct(WorkOrderService $workOrder, WorkOrderReportService $report, WorkOrderReportValidator $reportValidator){
            $this->workOrder = $workOrder;
            $this->report = $report;
            $this->reportValidator = $reportValidator;
        }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($workOrder_id, $data){
            $validator = new $this->reportValidator;
            
            if($validator->passes()){
            
                try{

                    $workOrder = $this->workOrder->find($workOrder_id);
                    
                    $data['work_order_id'] = $workOrder->id;
                    
                    if($record = $this->report->create($data)){
                        $this->message = 'Successfully created work order report';
                        $this->messageType = 'success';
                        $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));

                    } else{
                        $this->message = 'There was an error creating a work order report. Please try again.';
                        $this->messageType = 'danger';
                        $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));
                    }

                } catch (RecordNotFoundException $e) {
                    return $this->workOrderNotFound();
                }
                
            } else{
                $this->errors = $validator->getErrors();
                $this->redirect = route('maintenance.work-orders.show', array($workOrder_id));
            }
            
            return $this->response();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($workOrder_id, $report_id){
            try{
                
            } catch (RecordNotFoundException $e) {

            }
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($workOrder_id, $report_id){
            try{
                
            } catch (RecordNotFoundException $e) {

            }
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($workOrder_id, $report_id){
            try{
                
            } catch (RecordNotFoundException $e) {

            }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($workOrder_id, $report_id){
            try{
                
            } catch (RecordNotFoundException $e) {

            }
	}
        
        public function workOrderNotFound(){
            $this->message = 'Work order not found; It either does not exist, or has been deleted';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.index');
            
            return $this->response();
        }


}
