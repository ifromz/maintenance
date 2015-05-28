<?php

namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Validators\WorkOrder\SessionValidator;
use Stevebauman\Maintenance\Services\WorkOrder\SessionService;
use Stevebauman\Maintenance\Services\WorkOrder\WorkOrderService;
use Stevebauman\Maintenance\Controllers\BaseController;

/**
 * Class SessionController.
 */
class SessionController extends BaseController
{
    /**
     * @var WorkOrderService
     */
    protected $workOrder;

    /**
     * @var SessionService
     */
    protected $session;

    /**
     * @var SessionValidator
     */
    protected $sessionValidator;

    /**
     * Constructor.
     *
     * @param WorkOrderService $workOrder
     * @param SessionService   $session
     * @param SessionValidator $sessionValidator
     */
    public function __construct(
        WorkOrderService $workOrder,
        SessionService $session,
        SessionValidator $sessionValidator
    ) {
        $this->workOrder = $workOrder;
        $this->session = $session;
        $this->sessionValidator = $sessionValidator;
    }

    /**
     * Displays the sessions for the specified
     * user for the specified work order.
     *
     * @param int|string $workOrderId
     * @param int|string $userId
     *
     * @return \Illuminate\View\View
     */
    public function showUser($workOrderId, $userId)
    {
        $workOrder = $this->workOrder->find($workOrderId);

        $sessions = $this->session
            ->setInput($this->inputAll())
            ->getSessionsForWorkOrderAndUser($workOrderId, $userId);

        if($sessions->count() === 0) {
            $message = "This user either does not exist or does not have any sessions for this work order.";

            $this->message = $message;
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', [$workOrder->id]);

            return $this->response();
        }

        $user = $sessions->first()->user;

        return view('maintenance::work-orders.sessions.show-user', [
            'title' => "Work Order Sessions",
            'sessions' => $sessions,
            'user' => $user,
        ]);
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

        $this->sessionValidator->addRule('work_order_id', 'session_start');

        if($this->sessionValidator->setInput($data)->passes()) {
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
        } else {
            $this->errors = $this->sessionValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.show', [$workOrderId]);
        }

        return $this->response();
    }

    /**
     * Ends a maintenance workers session on a work order.
     *
     * @param int|string $workOrderId
     * @param int|string $session_id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postEnd($workOrderId, $session_id)
    {
        $data = $this->inputAll();
        $data['work_order_id'] = $workOrderId;

        $this->sessionValidator->addRule('work_order_id', 'session_end');

        if($this->sessionValidator->setInput($data)->passes()) {
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
        } else {
            $this->errors = $this->sessionValidator->getErrors();
            $this->redirect = route('maintenance.work-orders.show', [$workOrderId]);
        }

        return $this->response();
    }
}
