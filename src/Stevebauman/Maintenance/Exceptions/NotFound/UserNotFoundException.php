<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class UserNotFoundException extends BaseException
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'User']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.admin.users.index');
    }
}

App::error(function (UserNotFoundException $e) {
    return $e->response();
});
