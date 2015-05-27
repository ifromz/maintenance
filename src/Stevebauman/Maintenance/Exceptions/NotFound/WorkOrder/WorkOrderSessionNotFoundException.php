<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder;

use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkOrderSessionNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Work Order Session']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.show', $this->getRouteParameter('work_orders'));
    }
}
