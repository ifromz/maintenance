<?php namespace Stevebauman\Maintenance\Validators;

use Route;
use Lang;
use Illuminate\Validation\Validator;
use Stevebauman\Maintenance\Services\LocationService;
use Stevebauman\Maintenance\Services\CategoryService;

class CategorySlugValidator extends Validator {

	public function __construct($translator, $data, $rules, $messages, LocationService $location, CategoryService $category){
		$this->translator = $translator;
		$this->data = $data;
		$this->rules = $this->explodeRules($rules);
		$this->messages = $messages;
		
		$this->location = $location;
		$this->category = $category;
	}
	
	/**
     * Validates inputted category slug. 
	 * This checks if the slug used in the category is used again inside the same subtree nodes or root nodes.
     *
     * @author Steve Bauman
     *
	 * @param $attribute, $value, $parameters
     * @return boolean
     */
	public function validateCategorySlug($attribute, $value, $parameters){
		$location_id = Route::getCurrentRoute()->getParameter('locations');
		$category_id = Route::getCurrentRoute()->getParameter('categories');
		
		// Check if a category node ID is supplied, if not grab category list from locations
		if(is_null($category_id)){
			$location = $this->location->find($location_id);
			
			$categories = $this->category->getLocationCategories($location);
			
			foreach($categories as $category){
				if($category->isRoot()){
					if($value == $category->slug){
						return false;
					}
				}
			}
		} else{
			$category = $this->category->find($category_id);
			
			foreach($category->getDescendants() as $child){
				if($value == $child->slug){
					return false;
				}
			}
		}
		
		return true;
	}
	
	protected function replaceCategorySlug($message, $attribute, $rule, $parameters){
		return Lang::get('maintenance::validation.category-slug');
	}
	
}