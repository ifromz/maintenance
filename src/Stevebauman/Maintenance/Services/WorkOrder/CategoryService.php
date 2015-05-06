<?php

namespace Stevebauman\Maintenance\Services\WorkOrder;

use Stevebauman\Maintenance\Exceptions\NotFound\WorkOrder\WorkOrderCategoryNotFoundException;
use Stevebauman\Maintenance\Models\Category;
use Stevebauman\Maintenance\Services\CategoryService as BaseCategoryService;

/**
 * Class CategoryService
 * @package Stevebauman\Maintenance\Services\WorkOrder
 */
class CategoryService extends BaseCategoryService
{
    /**
     * The nested set scope ID.
     *
     * @var string
     */
    protected $scoped_id = 'work_orders';

    /**
     * Constructor.
     *
     * @param Category $workOrderCategory
     * @param WorkOrderCategoryNotFoundException $notFoundException
     */
    public function __construct(Category $workOrderCategory, WorkOrderCategoryNotFoundException $notFoundException)
    {
        $this->model = $workOrderCategory;
        $this->notFoundException = $notFoundException;
    }
}
