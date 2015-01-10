<?php

namespace Stevebauman\Maintenance\Composers;

/**
 * Class PublicLayoutComposer
 * @package Stevebauman\Maintenance\Composers
 */
class PublicLayoutComposer
{

    /**
     * @param $view
     */
    public function compose($view)
    {
        $siteTitle = config('maintenance::site.title.public', 'Maintenance');
        $view->with('siteTitle', $siteTitle);
    }

}