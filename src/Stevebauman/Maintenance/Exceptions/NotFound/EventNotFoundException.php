<?php

namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class EventNotFoundException extends BaseException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Event'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.events.index');
    }
    
}

App::error(function(EventNotFoundException $e, $code, $fromConsole){
    return $e->response();
});