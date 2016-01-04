<?php

namespace App\Http\Apis\v1;

use App\Repositories\LocationRepository;

class LocationController extends CategoryController
{
    /**
     * @param LocationRepository $repository
     */
    public function __construct(LocationRepository $repository)
    {
        $this->repository = $repository;
    }
}
