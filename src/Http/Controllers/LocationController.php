<?php namespace Stevebauman\Maintenance\Http\Controllers;

use Stevebauman\Maintenance\Services\LocationService;
use Stevebauman\Maintenance\Validators\LocationValidator;
use Stevebauman\Maintenance\Controllers\AbstractNestedSetController;

class LocationController extends AbstractNestedSetController {
	
	public function __construct(LocationService $location, LocationValidator $locationValidator){
		$this->service = $location;
		$this->serviceValidator = $locationValidator;
		
		$this->indexTitle = 'All Locations';
		$this->createTitle = 'Create a Location';
		$this->editTitle = 'Edit Location';
	}
	
}