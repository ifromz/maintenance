<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder;

use Stevebauman\Maintenance\Exceptions\BaseException;

class WorkRequestNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Work Request']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.work-requests.index');
    }
}
