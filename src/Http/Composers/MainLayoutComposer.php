<?php namespace Stevebauman\Maintenance\Http\Composers;

use Illuminate\Support\Facades\Config;

class MainLayoutComposer {
	
	public function compose($view){
            $site_title = Config::get('maintenance::site.title.backend', 'Maintenance');
            $view->with('site_title', $site_title);
	}
	
}