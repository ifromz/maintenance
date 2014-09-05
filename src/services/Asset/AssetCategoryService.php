<?php namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Services\AbstractModelService;
use Stevebauman\Maintenance\Models\AssetCategory;

class AssetCategoryService extends AbstractModelService {
	
	public function __construct(AssetCategory $assetCategory){
		$this->model = $assetCategory;
	}
	
}