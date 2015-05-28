<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Stevebauman\Maintenance\Services\Asset\CategoryService;
use Stevebauman\Maintenance\Validators\CategoryValidator;
use Stevebauman\Maintenance\Http\Controllers\AbstractNestedSetController;

/**
 * Class CategoryController.
 */
class CategoryController extends AbstractNestedSetController
{
    /**
     * @param CategoryService   $assetCategory
     * @param CategoryValidator $categoryValidator
     */
    public function __construct(CategoryService $assetCategory, CategoryValidator $categoryValidator)
    {
        $this->service = $assetCategory;
        $this->serviceValidator = $categoryValidator;
        $this->resource = 'Asset Category';
    }
}
