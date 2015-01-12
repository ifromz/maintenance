<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class InventoryCategoryNotFoundException extends BaseException {

    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Inventory Category'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.inventory.categories.index');
    }

}

App::error(function(InventoryNotFoundException $e){
    return $e->response();
});