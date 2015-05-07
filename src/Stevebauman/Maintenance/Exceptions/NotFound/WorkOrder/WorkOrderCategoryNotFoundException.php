<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkOrderCategoryNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Work Order Category']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.categories.index');
    }
}

App::error(function (WorkOrderCategoryNotFoundException $e) {
    return $e->response();
});
