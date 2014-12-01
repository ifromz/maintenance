<?php

namespace Stevebauman\Maintenance\Services;

use Stevebauman\Maintenance\Models\AssetCategory;
use Stevebauman\Maintenance\Services\BaseNestedSetModelService;

class AssetCategoryService extends BaseNestedSetModelService {
    
    public function __construct(AssetCategory $assetCategory)
    {
        $this->model = $assetCategory;
    }
    
    public function roots()
    {
        return $this->model->roots()->get();
    }
    
}