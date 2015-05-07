<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkOrderReportNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Work Order Report']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.show', $this->getRouteParameter('work_orders'));
    }
}

App::error(function (WorkOrderReportNotFoundException $e) {
    return $e->response();
});
