<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder;

use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkOrderNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Work Order']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-orders.index');
    }
}
