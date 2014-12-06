<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkOrderAssignmentNotFoundException extends BaseException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Work Order Assignment'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.show', $this->getRouteParameter('work_orders'));
    }
    
}

App::error(function(WorkOrderAssignmentNotFoundException $e, $code, $fromConsole){
    return $e->response();
});