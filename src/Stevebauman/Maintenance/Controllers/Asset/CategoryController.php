<?php namespace Stevebauman\Maintenance\Controllers\Asset;

use Stevebauman\Maintenance\Services\Asset\CategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Controllers\AbstractNestedSetController;

/**
 * Class CategoryController
 * @package Stevebauman\Maintenance\Controllers\Asset
 */
class CategoryController extends AbstractNestedSetController
{

	/**
	 * @param CategoryService $assetCategory
	 * @param CategoryValidator $categoryValidator
	 */
	public function __construct(CategoryService $assetCategory, CategoryValidator $categoryValidator)
	{
		$this->service = $assetCategory;
		$this->serviceValidator = $categoryValidator;
		$this->resource = 'Asset Category';
	}
	
}