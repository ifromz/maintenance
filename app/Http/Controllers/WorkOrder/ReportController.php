<?php

namespace App\Http\Controllers\WorkOrder;

use App\Http\Controllers\Controller as BaseController;
use App\Http\Requests\WorkOrder\ReportRequest;
use App\Repositories\WorkOrder\ReportRepository;
use App\Repositories\WorkOrder\Repository as WorkOrderRepository;

class ReportController extends BaseController
{
    /**
     * @var WorkOrderRepository
     */
    protected $workOrder;

    /**
     * @var ReportRepository
     */
    protected $report;

    /**
     * Constructor.
     *
     * @param WorkOrderRepository $workOrder
     * @param ReportRepository    $report
     */
    public function __construct(WorkOrderRepository $workOrder, ReportRepository $report)
    {
        $this->workOrder = $workOrder;
        $this->report = $report;
    }

    /**
     * Displays the form for creating a report
     * for the specified work order.
     *
     * @param int|string $workOrderId
     *
     * @return \Illuminate\View\View
     */
    public function create($workOrderId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        return view('work-orders.report.create', compact('workOrder'));
    }

    /**
     * Creates a new report for the specified work order.
     *
     * @param ReportRequest $request
     * @param int|string    $workOrderId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReportRequest $request, $workOrderId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        $report = $this->report->create($request, $workOrder->id);

        if ($report) {
            // Complete the work order.
            $workOrder->complete($request);

            $message = 'Successfully created work order report.';

            return redirect()->route('maintenance.work-orders.show', [$workOrder->id])->withSuccess($message);
        } else {
            $message = 'There was an issue creating a work order report. Please try again';

            return redirect()->route('maintenance.work-orders.report.create', [$workOrder->id])->withErrors($message);
        }
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
