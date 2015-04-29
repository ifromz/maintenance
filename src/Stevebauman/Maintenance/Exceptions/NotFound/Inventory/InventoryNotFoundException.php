<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\Inventory;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class InventoryNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource'=>'Inventory Item']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.inventory.index');
    }
}

App::error(function(InventoryNotFoundException $e){
    return $e->response();
});