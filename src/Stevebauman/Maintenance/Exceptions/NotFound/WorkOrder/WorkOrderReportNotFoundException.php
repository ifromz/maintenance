<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkOrderReportNotFoundException extends BaseException{
    
    public function __constuct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Work Order Report'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.show', $this->getRouteParameter('work_orders'));
    }
    
}

App::error(function(WorkOrderReportNotFoundException $e, $code, $fromConsole){
    return $e->response();
});