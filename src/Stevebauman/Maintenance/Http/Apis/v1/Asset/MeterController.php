<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Models\Meter;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Apis\v1\Controller as BaseController;

class MeterController extends BaseController
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
     * Returns a new grid instance of the specified assets meters.
     *
     * @param int|string $id
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function grid($id)
    {
        $columns = [
            'id',
            'name',
            'user_id',
            'metric_id',
            'created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function(Meter $meter) use ($id)
        {
            return [
                'id' => $meter->id,
                'name' => $meter->name,
                'user' => ($meter->user ? $meter->user->full_name : '<em>None</em>'),
                'metric' => ($meter->metric ? $meter->metric->name : '<em>None</em>'),
                'reading' => $meter->last_reading,
                'comment' => $meter->last_comment,
                'created_at' => $meter->created_at,
                'view_url' => route('maintenance.assets.meters.show', [$id, $meter->id]),
            ];
        };

        return $this->asset->gridMeters($id, $columns, $settings, $transformer);
    }
}