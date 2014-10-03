<?php  namespace Stevebauman\Maintenance\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Stevebauman\Maintenance\Validators\WorkOrderReportValidator;
use Stevebauman\Maintenance\Services\WorkOrderReportService;
use Stevebauman\Maintenance\Services\WorkOrderService;
use Stevebauman\Maintenance\Http\Controllers\AbstractController;

class WorkOrderReportController extends AbstractController {
        
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
	public function store($workOrder_id){
            $validator = new $this->reportValidator;
            
            if($validator->passes()){

                $workOrder = $this->workOrder->find($workOrder_id);
                
                if($record = $this->report->create($workOrder->id)){

                    $workOrder->update(array(
                        'status' => Config::get('maintenance::status.complete')
                    ));

                    $this->message = 'Successfully created work order report';
                    $this->messageType = 'success';
                    $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));

                } else{
                    $this->message = 'There was an error creating a work order report. Please try again.';
                    $this->messageType = 'danger';
                    $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));
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
