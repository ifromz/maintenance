<?php

namespace Stevebauman\Maintenance\Http\Controllers\Asset;

use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Controllers\Controller as BaseController;

class WorkOrderController extends BaseController
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

    /**
     * Displays all work orders attached to the specified asset.
     *
     * @param int|string $assetId
     *
     * @return \Illuminate\View\View
     */
    public function index($assetId)
    {
        $asset = $this->asset->find($assetId);

        return view('maintenance::assets.work-orders.index', compact('asset'));
    }
}
