<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\Support\Facades\Config;

class AdminLayoutComposer
{

    public function compose($view)
    {
        $siteTitle = Config::get('maintenance::site.title.admin');

        $view->with('siteTitle', $siteTitle);
    }

}