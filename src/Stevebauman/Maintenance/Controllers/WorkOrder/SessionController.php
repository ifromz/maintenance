<?php namespace Stevebauman\Maintenance\Controllers\WorkOrder;

use Stevebauman\Maintenance\Services\WorkOrder\SessionService;
use Stevebauman\Maintenance\Controllers\BaseController;

class SessionController extends BaseController
{

    public function __construct(SessionService $session)
    {
        $this->session = $session;
    }

    public function postStart($workOrder_id)
    {

        $data = $this->inputAll();
        $data['work_order_id'] = $workOrder_id;

        $record = $this->session->setInput($data)->create();

        if ($record) {
            $this->message = "You have been checked into this work order. Don't forget to checkout";
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.show', array($record->work_order_id));
        } else {
            $this->message = "There was an error trying to check you into this work order. Please try again";
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', array($record->work_order_id));
        }

        return $this->response();
    }

    public function postEnd($workOrder_id, $session_id)
    {

        $data = $this->inputAll();
        $data['work_order_id'] = $workOrder_id;

        $record = $this->session->setInput($data)->update($session_id);

        if ($record) {
            $this->message = "You have been checked out of this work order. Your hours have been logged.";
            $this->messageType = 'success';
            $this->redirect = route('maintenance.work-orders.show', array($record->work_order_id));
        } else {
            $this->message = "There was an error trying to check you out of this work order. Please try again";
            $this->messageType = 'danger';
            $this->redirect = route('maintenance.work-orders.show', array($workOrder_id));
        }

        return $this->response();
    }

}
