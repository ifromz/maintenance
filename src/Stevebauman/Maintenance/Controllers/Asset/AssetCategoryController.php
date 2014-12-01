<?php namespace Stevebauman\Maintenance\Controllers;

use Stevebauman\Maintenance\Services\AssetCategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Controllers\BaseNestedSetController;

class AssetCategoryController extends BaseNestedSetController {
	
	public function __construct(
                AssetCategoryService $assetCategory, CategoryValidator $categoryValidator){
		$this->service = $assetCategory;
		$this->serviceValidator = $categoryValidator;
		
                $this->resource = 'Asset Category';
	}
	
}