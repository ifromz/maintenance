<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Stevebauman\Maintenance\Http\Requests\WorkOrder\SessionEndRequest;
use Stevebauman\Maintenance\Http\Requests\WorkOrder\SessionStartRequest;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Repositories\WorkOrder\SessionRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

/**
 * Class SessionController.
 */
class SessionController extends BaseController
{
    /**
     * Constructor.
     *
     * @param SessionRepository $session
     */
    public function __construct(SessionRepository $session, WorkOrderRepository $workOrder)
    {
        $this->session = $session;
    }

    /**
     * Starts a maintenance workers session on a work order.
     *
     * @param SessionStartRequest $request
     * @param int|string          $workOrderId
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postStart(SessionStartRequest $request, $workOrderId)
    {
        $session = $this->session->create($workOrderId);

        if($session) {
            $message = "Successfully started your session. Don't forget to check out!";

            return redirect()->route('maintenance.work-orders.show', [$workOrderId])->withSuccess($message);
        } else {
            $message = "There was an issue creating your session. Please try again.";

            return redirect()->route('maintenance.work-orders.show', [$workOrderId])->withErrors($message);
        }
    }

    /**
     * Ends a maintenance workers session on a work order.
     *
     * @param SessionEndRequest $request
     * @param int|string        $workOrderId
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postEnd(SessionEndRequest $request, $workOrderId)
    {
        $session = $this->session->update($workOrderId);

        if($session) {
            $message = "Successfully ended your session. Your hours have been logged.";

            return redirect()->route('maintenance.work-orders.show', [$workOrderId])->withSuccess($message);
        } else {
            $message = "There was an issue ending your session. Please try again.";

            return redirect()->route('maintenance.work-orders.show', [$workOrderId])->withErrors($message);
        }
    }
}
