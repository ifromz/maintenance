<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Models\Category;

class CategoryService extends AbstractModelService {
	
	public function __construct(Category $category){
		$this->model = $category;
	}
	
}