<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\CategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Controllers\AbstractNestedSetController;

class CategoryController extends AbstractNestedSetController {
	
	public function __construct(CategoryService $category, CategoryValidator $categoryValidator){
		$this->service = $category;
		$this->serviceValidator = $categoryValidator;
		
                $this->resource = 'Inventory / Asset Category';
	}
	
}