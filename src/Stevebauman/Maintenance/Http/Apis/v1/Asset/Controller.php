<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class Controller extends BaseController
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
     * Returns a new grid instance of all assets.
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid()
    {
        $columns = [
            'id',
            'name',
            'location_id',
            'category_id',
            'condition',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function($asset) {
            return [
                'id' => $asset->id,
                'name' => $asset->name,
                'condition' => $asset->condition,
                'location' => ($asset->location ? $asset->location->trail : '<em>None</em>'),
                'category' => ($asset->category ? $asset->categrory->trail : '<em>None</em>'),
                'created_at' => $asset->created_at,
            ];
        };

        return $this->asset->grid($columns, $settings, $transformer);
    }
}
