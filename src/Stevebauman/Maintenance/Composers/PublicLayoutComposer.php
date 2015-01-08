<?php

namespace Stevebauman\Maintenance\Composers;

class PublicLayoutComposer
{

    public function compose($view)
    {
        $siteTitle = config('maintenance::site.title.public', 'Maintenance');
        $view->with('siteTitle', $siteTitle);
    }

}