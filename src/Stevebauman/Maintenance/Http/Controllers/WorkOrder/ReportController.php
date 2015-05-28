<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\WorkOrder\ReportValidator;
use Stevebauman\Maintenance\Services\WorkOrder\ReportService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Http\Controllers\Controller;

class ReportController extends Controller
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
     * @var ReportValidator
     */
    protected $reportValidator;

    /**
     * Constructor.
     *
     * @param WorkOrderService $workOrder
     * @param ReportService    $report
     * @param ReportValidator  $reportValidator
     */
    public function __construct(WorkOrderService $workOrder, ReportService $report, ReportValidator $reportValidator)
    {
        $this->workOrder = $workOrder;
        $this->report = $report;
        $this->reportValidator = $reportValidator;
    }

    /**
     * Displays the form for creating a report
     * for the specified work order.
     *
     * @param int|string $workOrder_id
     *
     * @return \Illuminate\View\View
     */
    public function create($workOrder_id)
    {
        $workOrder = $this->workOrder->find($workOrder_id);

        return view('maintenance::work-orders.report.create', [
            'title' => 'Create a Work Order Report',
            'workOrder' => $workOrder,
        ]);
    }

    /**
     * Creates a new report for the specified work order.
     *
     * @param int|string $workOrder_id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
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
                $this->redirect = route('maintenance.work-orders.show', [$workOrder->id]);
            } else {
                $this->message = 'There was an error creating a work order report. Please try again.';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.work-orders.show', [$workOrder->id]);
            }
        } else {
            $this->errors = $this->reportValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.show', [$workOrder_id]);
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
