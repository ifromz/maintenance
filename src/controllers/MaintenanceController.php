<?php namespace Stevebauman\Maintenance\Controllers;

use Illuminate\Support\Facades\View;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Controllers\BaseController;

class MaintenanceController extends BaseController {
	
	public function __construct(SentryService $sentry){
            $this->sentry = $sentry;
	}
	
	public function getIndex(){
		$this->layout = View::make('maintenance::dashboard.index');
		$this->layout->title = 'Dashboard';
	}
}