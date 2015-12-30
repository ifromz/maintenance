<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Stevebauman\Maintenance\Http\Controllers\NestedSetController;
use Stevebauman\Maintenance\Repositories\Asset\CategoryRepository;

class CategoryController extends NestedSetController
{
    /**
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;

        $this->resource = 'Asset Category';

        $this->routes = [
            'index'       => 'maintenance.assets.categories.index',
            'create'      => 'maintenance.assets.categories.create',
            'create-node' => 'maintenance.assets.categories.nodes.create',
            'store'       => 'maintenance.assets.categories.store',
            'edit'        => 'maintenance.assets.categories.edit',
            'update'      => 'maintenance.assets.categories.update',
            'destroy'     => 'maintenance.assets.categories.destroy',
            'grid'        => 'maintenance.api.v1.assets.categories.grid',
            'move'        => 'maintenance.api.v1.assets.categories.move',
        ];
    }
}
