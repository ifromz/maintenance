<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Stevebauman\Maintenance\Repositories\WorkOrder\CategoryRepository;
use Stevebauman\Maintenance\Http\Apis\v1\CategoryController as BaseController;

class CategoryController extends BaseController
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
