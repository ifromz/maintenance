<?php

namespace Stevebauman\Maintenance\Apis\v1\Asset;

use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Http\Apis\v1\BaseApi;

class AssetApi extends BaseApi
{
    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * Constructor.
     *
     * @param AssetService $asset
     */
    public function __construct(AssetService $asset)
    {
        $this->asset = $asset;
    }

    public function get()
    {
        return $this->responseJson($this->asset->get());
    }

    public function find($id)
    {
        if (is_int($id)) {
            return $this->responseJson($this->asset->find($id));
        } else {
            return $this->responseJson($this->asset->where('name', $id)->get());
        }
    }
}
