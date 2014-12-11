<?php namespace Stevebauman\Maintenance\Controllers\Asset;

use Stevebauman\Maintenance\Services\Asset\CategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Controllers\BaseNestedSetController;

class CategoryController extends BaseNestedSetController {
	
	public function __construct(
                CategoryService $assetCategory, CategoryValidator $categoryValidator){
		$this->service = $assetCategory;
		$this->serviceValidator = $categoryValidator;
		
                $this->resource = 'Asset Category';
	}
	
}