<?php

namespace Stevebauman\Maintenance\Composers;

use Illuminate\View\View;
use Stevebauman\Maintenance\Services\Asset\AssetService;

/**
 * Class AssetSelectComposer.
 */
class AssetSelectComposer
{
    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * @param AssetService $asset
     */
    public function __construct(AssetService $asset)
    {
        $this->asset = $asset;
    }

    /**
     * @param $view
     *
     * @return mixed
     */
    public function compose(View $view)
    {
        $allAssets = $this->asset->orderBy('name', 'ASC')->get()->lists('name', 'id');

        return $view->with('allAssets', $allAssets);
    }
}
