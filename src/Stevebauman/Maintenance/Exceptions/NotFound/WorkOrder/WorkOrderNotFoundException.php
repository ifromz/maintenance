<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\AbstractException;

class WorkOrderNotFoundException extends AbstractException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Work Order'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.index');
    }
    
}

App::error(function(WorkOrderNotFoundException $e, $code, $fromConsole){
    return $e->response();
});