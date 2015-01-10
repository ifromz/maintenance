<?php namespace Stevebauman\Maintenance\Exceptions;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class InventoryStockMovementNotFoundException extends BaseException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Inventory Stock Movement'));
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.inventory.stocks.show', $this->getRouteParameter('inventory'), $this->getRouteParameter('stocks'));
    }
    
}

App::error(function(InventoryStockMovementNotFoundException $e, $code, $fromConsole){
    return $e->response();
});