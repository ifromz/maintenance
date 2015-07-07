<?php

namespace Stevebauman\Maintenance\Services\Asset;

use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\CategoryService as BaseCategoryService;

/**
 * Class CategoryService.
 */
class CategoryService extends BaseCategoryService
{
    /**
     * @var Category
     */
    protected $model;

    /**
     * The nested set scope ID.
     *
     * @var string
     */
    protected $scoped_id = 'assets';

    /**
     * Constructor.
     *
     * @param Category                       $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }
}
