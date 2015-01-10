<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;

/**
 * Class MainLayoutComposer
 * @package Stevebauman\Maintenance\Composers
 */
class MainLayoutComposer
{

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $siteTitle = config('maintenance::site.title.main');

        $view->with('siteTitle', $siteTitle);
    }

}