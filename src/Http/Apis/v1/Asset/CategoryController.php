<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Http\Apis\v1\CategoryController as BaseCategoryController;
use Stevebauman\Maintenance\Repositories\Asset\CategoryRepository;

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
