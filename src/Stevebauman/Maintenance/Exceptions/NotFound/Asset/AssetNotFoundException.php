<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\AbstractException;

class AssetNotFoundException extends AbstractException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Asset'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.assets.index');
    }
    
}

App::error(function(AssetNotFoundException $e, $code, $fromConsole){
    return $e->response();
});