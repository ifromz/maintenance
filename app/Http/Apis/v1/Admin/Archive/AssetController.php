<?php

namespace App\Http\Apis\v1\Admin\Archive;

use App\Repositories\Asset\Repository as AssetRepository;

class AssetController extends AssetRepository
{
    /**
     * @var AssetRepository
     */
    protected $asset;

    /**
     * Constructor.
     *
     * @param AssetRepository $asset
     */
    public function __construct(AssetRepository $asset)
    {
        $this->asset = $asset;
    }

    public function grid()
    {
    }
}
