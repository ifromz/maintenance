<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Http\Apis\v1\CategoryController as BaseCategoryController;
use Stevebauman\Maintenance\Repositories\WorkOrder\CategoryRepository;

class CategoryController extends BaseCategoryController
{
    /**
     * Constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
}
