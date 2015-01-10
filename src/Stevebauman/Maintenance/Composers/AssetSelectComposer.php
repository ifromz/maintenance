<?php

namespace Stevebauman\Maintenance\Composers;

use Stevebauman\Maintenance\Services\Asset\AssetService;

/**
 * Class AssetSelectComposer
 * @package Stevebauman\Maintenance\Composers
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
     * @return mixed
     */
    public function compose($view)
    {
        $allAssets = $this->asset->get()->lists('name', 'id');

        return $view->with('allAssets', $allAssets);
    }

}
