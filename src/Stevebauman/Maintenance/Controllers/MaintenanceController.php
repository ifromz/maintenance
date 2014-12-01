<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\BaseController;

class MaintenanceController extends BaseController {
        
	public function getIndex()
        {
            return $this->view('maintenance::dashboard.index', array(
                'title' => 'Dashboard'
            ));
	}
}