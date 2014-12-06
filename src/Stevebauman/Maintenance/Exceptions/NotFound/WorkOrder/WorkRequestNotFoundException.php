<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkRequestNotFoundException extends BaseException{
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Work Request'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-requests.index');
    }
    
}

App::error(function(WorkRequestNotFoundException $e, $code, $fromConsole){
    return $e->response();
});