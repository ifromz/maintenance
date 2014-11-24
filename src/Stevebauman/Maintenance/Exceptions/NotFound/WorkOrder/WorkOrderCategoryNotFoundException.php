<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\AbstractException;

class WorkOrderCategoryNotFoundException extends AbstractException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Work Order Category'));
        $this->messageType = 'danger';
        $this->redirect = route('maintenance.work-orders.categories.index');
    }
    
}

App::error(function(WorkOrderCategoryNotFoundException $e, $code, $fromConsole){
    return $e->response();
});