<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound;

use Stevebauman\Maintenance\Exceptions\BaseException;

class EventNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Event']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.events.index');
    }
}
