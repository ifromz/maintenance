<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Controllers\AbstractController;

class MaintenanceController extends AbstractController {
        
	public function getIndex()
        {
            return $this->view('maintenance::dashboard.index', array(
                'title' => 'Dashboard'
            ));
	}
}