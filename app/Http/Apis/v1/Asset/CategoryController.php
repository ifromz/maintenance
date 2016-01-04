<?php

namespace App\Http\Apis\v1\Asset;

use App\Http\Apis\v1\CategoryController as BaseCategoryController;
use App\Repositories\Asset\CategoryRepository;

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
