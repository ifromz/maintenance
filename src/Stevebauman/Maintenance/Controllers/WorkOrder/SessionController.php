<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\SessionService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class SessionController.
 */
class SessionController extends BaseController
{
    /**
     * @var SessionService
     */
    protected $session;

    /**
     * @param SessionService $session
     */
    public function __construct(SessionService $session)
    {
        $this->session = $session;
    }

    /**
     * Starts a maintenance workers session on a work order.
     *
     * @param int|string $workOrderId
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postStart($workOrderId)
    {
        $data = $this->inputAll();
        $data['work_order_id'] = $workOrderId;

        $record = $this->session->setInput($data)->create();

        if ($record) {
            $this->message = "You have been checked into this work order. Don't forget to checkout!";
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.show', [$workOrderId]);
        } else {
            $this->message = 'There was an error trying to check you into this work order. Please try again';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', [$workOrderId]);
        }

        return $this->response();
    }

    /**
     * Ends a maintenance workers session on a work order.
     *
     * @param string|int $workOrderId
     * @param string|int $session_id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postEnd($workOrderId, $session_id)
    {
        $data = $this->inputAll();
        $data['work_order_id'] = $workOrderId;

        $record = $this->session->setInput($data)->update($session_id);

        if ($record) {
            $this->message = 'You have been checked out of this work order. Your hours have been logged.';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.show', [$workOrderId]);
        } else {
            $this->message = 'There was an error trying to check you out of this work order. Please try again';
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', [$workOrderId]);
        }

        return $this->response();
    }
}
