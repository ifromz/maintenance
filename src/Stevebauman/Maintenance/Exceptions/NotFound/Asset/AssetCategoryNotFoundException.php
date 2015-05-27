<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\Asset;

use Stevebauman\Maintenance\Exceptions\BaseException;

class AssetCategoryNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Asset Category']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.assets.categories.index');
    }
}
