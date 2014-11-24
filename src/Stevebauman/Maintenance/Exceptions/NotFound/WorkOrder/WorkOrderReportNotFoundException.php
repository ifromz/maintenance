<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\AbstractException;

class WorkOrderReportNotFoundException extends AbstractException{
    
    public function __constuct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Work Order Report'));
        $this->messageType = 'danger';
        $this->redirect = route('maintenance.work-orders.show', $this->getRouteParameter('work_orders'));
    }
    
}

App::error(function(WorkOrderReportNotFoundException $e, $code, $fromConsole){
    return $e->response();
});