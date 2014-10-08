<?php namespace Stevebauman\Maintenance\Exceptions;

use Stevebauman\Maintenance\Exceptions\AbstractException;

class InventoryStockMovementNotFoundException extends AbstractException {
    
    public function __construct(){
        $this->message = trans('maintenance::errors.not-found', array('resource'=>'Inventory Stock Movement'));
        $this->messageType = 'danger';
        $this->redirect = route('maintenance.inventory.stocks.show', $this->getRouteParameter('inventory'), $this->getRouteParameter('stocks'));
    }
    
}

App::error(function(InventoryStockMovementNotFoundException $e, $code, $fromConsole){
    return $e->response();
});