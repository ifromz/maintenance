<?php

namespace Stevebauman\Maintenance\Exceptions\NotFound\Asset;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Exceptions\BaseException;

class AssetCategoryNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->message = trans('maintenance::errors.not-found', ['resource'=>'Asset Category']);
        $this->messageType = 'danger';
        $this->redirect = routeBack('maintenance.assets.categories.index');
    }
}

App::error(function(AssetEventNotFoundException $e){
    return $e->response();
});