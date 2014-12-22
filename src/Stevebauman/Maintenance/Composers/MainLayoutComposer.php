<?php 

namespace Stevebauman\Maintenance\Composers;

use Illuminate\Support\Facades\Config;

class MainLayoutComposer {
    
    public function compose($view)
    {
        $siteTitle = Config::get('maintenance::site.title.main');

        $view->with('siteTitle', $siteTitle);
    }
	
}