<?php namespace Stevebauman\Maintenance\Exceptions;

use Stevebauman\Maintenance\Exceptions\AbstractException;

class WorkOrderSessionNotFoundException extends AbstractException {
    
    public function __construct() {
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Work Order Session'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.show', $this->getRouteParameter('work_orders'));
    }
    
}

App::error(function(WorkOrderSessionNotFoundException $e, $code, $fromConsole){
    return $e->response();
});

