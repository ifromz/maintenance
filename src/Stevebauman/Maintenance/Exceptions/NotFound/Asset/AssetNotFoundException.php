<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\Asset;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class AssetNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource' => 'Asset']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.assets.index');
    }
}

App::error(function (AssetNotFoundException $e) {
    return $e->response();
});
