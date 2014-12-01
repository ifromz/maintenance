<?php  namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Validators\WorkOrderReportValidator;
use Stevebauman\Maintenance\Services\WorkOrderReportService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

class WorkOrderReportController extends BaseController {
        
        public function __construct(WorkOrderService $workOrder, WorkOrderReportService $report, WorkOrderReportValidator $reportValidator){
            $this->workOrder = $workOrder;
            $this->report = $report;
            $this->reportValidator = $reportValidator;
        }
        
        /**
         * Displays the form to create a work order report attached to the specified
         * work order
         * 
         * @param int $workOrder_id
         * @return response
         */
        public function create($workOrder_id){
            
            $workOrder = $this->workOrder->find($workOrder_id);
            
            return $this->view('maintenance::work-orders.report.create', array(
                'title' => 'Create a Work Order Report',
                'workOrder' => $workOrder
            ));
            
        }
        
        /**
         * Creates a new work order report attached to the specified work order
         * 
         * @param int $workOrder_id
         * @return response
         */
	public function store($workOrder_id){
            
            if($this->reportValidator->passes()){

                $workOrder = $this->workOrder->find($workOrder_id);
                
                $data = $this->inputAll();
                $data['work_order_id'] = $workOrder->id;
                
                if($this->report->setInput($data)->create()){
                    
                    $this->workOrder->setInput($data)->update($workOrder->id);

                    $this->message = 'Successfully created work order report';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));

                } else{
                    $this->message = 'There was an error creating a work order report. Please try again.';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));
                }

                
            } else{
                $this->errors = $this->reportValidator->getErrors();
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

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($workOrder_id, $report_id){

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($workOrder_id, $report_id){

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($workOrder_id, $report_id){

	}


}
