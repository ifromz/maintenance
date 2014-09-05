<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\AssetCategoryService;
use Stevebauman\Maintenance\Validators\AssetCategoryValidator;
use Stevebauman\Maintenance\Controllers\AbstractNestedSetController;

class AssetCategoryController extends AbstractNestedSetController {
	
	public function __construct(AssetCategoryService $category, AssetCategoryValidator $categoryValidator){
		$this->service = $category;
		$this->serviceValidator = $categoryValidator;
		
		$this->indexTitle = 'All Asset Categories';
		$this->createTitle = 'Create an Asset Category';
		$this->editTitle = 'Edit Category';
	}
	
}