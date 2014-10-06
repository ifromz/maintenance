<?php 

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\Location;
use Stevebauman\Maintenance\Services\AbstractNestedSetModelService;

class LocationService extends AbstractNestedSetModelService {
	
	public function __construct(Location $location){
		$this->model = $location;
	}
	
}