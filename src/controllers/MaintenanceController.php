<?php namespace Stevebauman\Maintenance\Controllers;

use View;
use Stevebauman\Maintenance\Controllers\BaseController;

class MaintenanceController extends BaseController {
	
	public function __construct(){
		
	}
	
	public function getIndex(){
		$this->layout = View::make('maintenance::dashboard.index');
		$this->layout->title = 'Dashboard';
	}
}