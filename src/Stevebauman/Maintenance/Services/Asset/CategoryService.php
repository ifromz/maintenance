<?php

namespace Stevebauman\Maintenance\Services\Asset;

use Stevebauman\Maintenance\Exceptions\NotFound\Asset\AssetCategoryNotFoundException;
use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\CategoryService as BaseCategoryService;

/**
 * Class CategoryService
 * @package Stevebauman\Maintenance\Services\Asset
 */
class CategoryService extends BaseCategoryService
{
    /**
     * The nested set scope ID.
     *
     * @var string
     */
    protected $scoped_id = 'assets';

    /**
     * Constructor.
     *
     * @param Category $category
     * @param AssetCategoryNotFoundException $notFoundException
     */
    public function __construct(Category $category, AssetCategoryNotFoundException $notFoundException)
    {
        $this->model = $category;
        $this->notFoundException = $notFoundException;
    }
}
