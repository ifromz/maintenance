<?php

namespace Stevebauman\Maintenance\Services\Asset;

use Stevebauman\Maintenance\Models\AssetCategory;
use Stevebauman\Maintenance\Services\BaseNestedSetModelService;

class CategoryService extends BaseNestedSetModelService
{

    public function __construct(AssetCategory $assetCategory)
    {
        $this->model = $assetCategory;
    }

    public function roots()
    {
        return $this->model->roots()->get();
    }

}