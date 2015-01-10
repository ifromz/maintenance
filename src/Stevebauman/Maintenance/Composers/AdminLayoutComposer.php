<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;

/**
 * Class AdminLayoutComposer
 * @package Stevebauman\Maintenance\Composers
 */
class AdminLayoutComposer
{

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $siteTitle = config('maintenance::site.title.admin');

        $view->with('siteTitle', $siteTitle);
    }

}