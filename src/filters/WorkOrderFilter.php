<?php namespace Stevebauman\Maintenance\Filters;

use App;
use Stevebauman\Maintenance\Services\CategoryService;
use Stevebauman\Maintenance\Services\WorkOrderService;

class WorkOrderFilter {
	
	public function __construct(CategoryService $category, WorkOrderService $workOrder){
		$this->category = $category;
		$this->workOrder = $workOrder;
	}
	
	/**
     * Filters the work order route.
	 * This checks if the location slug is valid as well as the hierarchy of categories.
     *
     * @author Steve Bauman
     * 
	 * @param $route, $request
     * @return Response or NULL
     */
	public function filter($route, $request){
		//Check if location is valid
		if($location = $this->location->getLocationBySlug($route->getParameter('locationSlug'))){
			//Check if hierarchy of categories is entered
			if($route->getParameter('hierarchy')){
				//Convert hierarchy into array
				$categories = explode('/', $route->getParameter('hierarchy'));
				
				//Check if category exists
				$main = $this->category->getCategoryBySlugAndLocationId(end($categories), $location->id);
				
				reset($categories);
				
				//If category exists
				if($main){
					//Check if location ID is equal to the main category ID
					if($main->location_id == $location->id){
						//Get the categories ancestors
						$ancestors = $main->getAncestors();
						$valid = true;
						
						//Check if each category slug entered inside the URL is a valid category
						foreach ($ancestors as $i => $category){
							if ($category->slug !== $categories[$i]){
								$valid = false;
								break;
							}
						}
						if(!$valid){
							return App::abort('404');
						}
					} else{
						return App::abort('404');
					}
				}
			} else{
				
			}
		} else{
			return App::abort('404');
		}
	}
	
}