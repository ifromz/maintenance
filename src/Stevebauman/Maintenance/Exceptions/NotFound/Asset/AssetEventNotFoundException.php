<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class AssetEventNotFoundException extends BaseException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Asset Event'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.assets.show', $this->getRouteParameter('assets'));
    }
    
}

App::error(function(AssetEventNotFoundException $e, $code, $fromConsole){
    return $e->response();
});