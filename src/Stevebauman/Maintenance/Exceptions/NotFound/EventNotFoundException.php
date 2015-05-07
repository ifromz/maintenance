<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound;

use Illuminate\Support\Facades\App;
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

App::error(function (EventNotFoundException $e) {
    return $e->response();
});
