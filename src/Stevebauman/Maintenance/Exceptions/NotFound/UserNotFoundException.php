<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound;

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
