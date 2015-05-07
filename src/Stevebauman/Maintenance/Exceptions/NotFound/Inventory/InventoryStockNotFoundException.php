<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\Inventory;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class InventoryStockNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Inventory Stock']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.inventory.show', $this->getRouteParameter('inventory'));
    }
}

App::error(function (InventoryStockNotFoundException $e) {
    return $e->response();
});
