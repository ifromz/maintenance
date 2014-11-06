<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\AssetCategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Controllers\AbstractNestedSetController;

class AssetCategoryController extends AbstractNestedSetController {
	
	public function __construct(
                AssetCategoryService $assetCategory, CategoryValidator $categoryValidator){
		$this->service = $assetCategory;
		$this->serviceValidator = $categoryValidator;
		
                $this->resource = 'Asset Category';
	}
	
}