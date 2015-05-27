<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\Asset;

use Stevebauman\Maintenance\Exceptions\BaseException;

class AssetEventNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Asset Event']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.assets.show', $this->getRouteParameter('assets'));
    }
}
