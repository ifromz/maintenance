<?php

namespace App\Composers;

use App\Repositories\Asset\Repository as AssetRepository;
use Illuminate\View\View;

class AssetSelectComposer
{
    /**
     * @var AssetRepository
     */
    protected $asset;

    /**
     * @param AssetRepository $asset
     */
    public function __construct(AssetRepository $asset)
    {
        $this->asset = $asset;
    }

    /**
     * @param View $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $allAssets = $this->asset->model()->orderBy('name', 'asc')->get()->lists('name', 'id')->toArray();

        return $view->with('allAssets', $allAssets);
    }
}
