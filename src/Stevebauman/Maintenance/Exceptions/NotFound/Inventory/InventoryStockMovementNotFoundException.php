<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\Inventory;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class InventoryStockMovementNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Inventory Stock Movement']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.inventory.stocks.show', $this->getRouteParameter('inventory'), $this->getRouteParameter('stocks'));
    }
}

App::error(function (InventoryStockMovementNotFoundException $e) {
    return $e->response();
});
