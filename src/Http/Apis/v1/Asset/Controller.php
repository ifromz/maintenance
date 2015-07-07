<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Models\Asset;
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
            'tag',
            'name',
            'location_id',
            'category_id',
            'condition',
            'created_at',
        ];

        $settings = [
            'sort' => 'created_at',
            'direction' => 'desc',
            'threshold' => 10,
            'throttle' => 10,
        ];

        $transformer = function(Asset $asset)
        {
            return [
                'tag' => $asset->tag,
                'name' => $asset->name,
                'condition' => $asset->condition,
                'location' => ($asset->location ? $asset->location->trail : '<em>None</em>'),
                'category' => ($asset->category ? $asset->category->trail : '<em>None</em>'),
                'created_at' => $asset->created_at,
                'view_url' => route('maintenance.assets.show', [$asset->id]),
            ];
        };

        return $this->asset->grid($columns, $settings, $transformer);
    }
}
