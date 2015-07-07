<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

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
    protected $scoped_id = 'work_orders';

    /**
     * Constructor.
     *
     * @param Category                           $workOrderCategory
     */
    public function __construct(Category $workOrderCategory)
    {
        $this->model = $workOrderCategory;
    }
}
