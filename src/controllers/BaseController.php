<?php namespace Stevebauman\Maintenance\Controllers;

use Controller;
use Config;
use View;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
		
		//share the config option to all the views
        $site_title = Config::get('maintenance::site.title',array());
        View::share('site_title', $site_title);
	}

}
