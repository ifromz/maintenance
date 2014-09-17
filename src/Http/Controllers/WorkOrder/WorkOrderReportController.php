<?php  namespace Stevebauman\Maintenance\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Stevebauman\Maintenance\Http\Requests\WorkOrderReportRequest;
use Stevebauman\Maintenance\Http\Controllers\BaseController;

class WorkOrderReportController extends BaseController {
    
        public function __construct(WorkOrderReportRequest $report){
            $this->report = $report;
        }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($workOrder_id){
            return $this->report->store($workOrder_id, Input::all());
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($workOrder_id, $report_id){
            return $this->report->show($workOrder_id, $report_id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($workOrder_id, $report_id){
            return $this->report->edit($workOrder_id, $report_id);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($workOrder_id, $report_id){
            return $this->report->update($workOrder_id, $report_id, Input::all());
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($workOrder_id, $report_id){
            return $this->report->destroy($workOrder_id, $report_id);
	}


}
