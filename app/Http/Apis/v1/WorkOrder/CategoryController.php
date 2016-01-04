<?php

namespace App\Http\Apis\v1\WorkOrder;

use App\Http\Apis\v1\CategoryController as BaseCategoryController;
use App\Repositories\WorkOrder\CategoryRepository;

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
