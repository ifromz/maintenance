<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;

/**
 * Class PublicLayoutComposer
 * @package Stevebauman\Maintenance\Composers
 */
class PublicLayoutComposer
{

    /**
     * @param $view
     */
    public function compose(View $view)
    {
        $siteTitle = config('maintenance::site.title.public', 'Maintenance');
        $view->with('siteTitle', $siteTitle);
    }

}