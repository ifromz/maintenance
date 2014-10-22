<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\AbstractException;

class MetricNotFoundException extends AbstractException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Metric'));
        $this->messageType = 'danger';
        $this->redirect = '';
    }
    
}

App::error(function(MetricNotFoundException $e, $code, $fromConsole){
    return $e->response();
});