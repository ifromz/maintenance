<?php

namespace Stevebauman\Maintenance\Controllers;

class MaintenanceController extends BaseController {
        
	public function getIndex()
        {
            return view('maintenance::dashboard.index', array(
                'title' => 'Dashboard'
            ));
	}
}