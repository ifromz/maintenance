<?php

namespace Stevebauman\Maintenance\Services\Asset;

use Stevebauman\Maintenance\Exceptions\NotFound\Asset\AssetCategoryNotFoundException;
use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\CategoryService as BaseCategoryService;

class CategoryService extends BaseCategoryService
{

    protected $scoped_id = 'assets';

    public function __construct(Category $category, AssetCategoryNotFoundException $notFoundException)
    {
        $this->model = $category;
        $this->notFoundException = $notFoundException;
    }

}