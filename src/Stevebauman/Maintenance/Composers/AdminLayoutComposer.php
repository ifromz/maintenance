<?php

namespace Stevebauman\Maintenance\Composers;

/**
 * Class AdminLayoutComposer
 * @package Stevebauman\Maintenance\Composers
 */
class AdminLayoutComposer
{

    /**
     * @param $view
     */
    public function compose($view)
    {
        $siteTitle = config('maintenance::site.title.admin');

        $view->with('siteTitle', $siteTitle);
    }

}