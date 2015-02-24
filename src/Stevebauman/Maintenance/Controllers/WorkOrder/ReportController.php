<?php namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\WorkOrderReportValidator;
use Stevebauman\Maintenance\Services\WorkOrder\ReportService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

class ReportController extends BaseController
{

    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var ReportService
     */
    protected $report;

    /**
     * @var WorkOrderReportValidator
     */
    protected $reportValidator;

    /**
     * @param WorkOrderService $workOrder
     * @param ReportService $report
     * @param WorkOrderReportValidator $reportValidator
     */
    public function __construct(WorkOrderService $workOrder, ReportService $report, WorkOrderReportValidator $reportValidator)
    {
        $this->workOrder = $workOrder;
        $this->report = $report;
        $this->reportValidator = $reportValidator;
    }

    /**
     * Displays the form to create a work order report attached to the specified
     * work order
     *
     * @param $workOrder_id
     * @return mixed
     */
    public function create($workOrder_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);

        return view('maintenance::work-orders.report.create', array(
            'title' => 'Create a Work Order Report',
            'workOrder' => $workOrder
        ));
    }

    /**
     * Creates a new work order report attached to the specified work order
     *
     * @param $workOrder_id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function store($workOrder_id)
    {
        if ($this->reportValidator->passes()) {

            $workOrder = $this->workOrder->find($workOrder_id);

            $data = $this->inputAll();
            $data['work_order_id'] = $workOrder->id;

            if ($this->report->setInput($data)->create()) {

                $this->workOrder->setInput($data)->update($workOrder->id);

                $this->message = 'Successfully created work order report';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));

            } else {
                $this->message = 'There was an error creating a work order report. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.show', array($workOrder->id));
            }


        } else {
            $this->errors = $this->reportValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.show', array($workOrder_id));
        }

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param $workOrder_id
     * @param $report_id
     */
    public function show($workOrder_id, $report_id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $workOrder_id
     * @param $report_id
     */
    public function edit($workOrder_id, $report_id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param $workOrder_id
     * @param $report_id
     */
    public function update($workOrder_id, $report_id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $workOrder_id
     * @param $report_id
     */
    public function destroy($workOrder_id, $report_id)
    {

    }


}
