<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkOrderNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource'=>'Work Order']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.index');
    }
}

App::error(function(WorkOrderNotFoundException $e) {
    return $e->response();
});