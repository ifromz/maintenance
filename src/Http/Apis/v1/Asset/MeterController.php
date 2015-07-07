<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Stevebauman\Maintenance\Models\Meter;
use Stevebauman\Maintenance\Models\MeterReading;
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
            'meters.id',
            'meters.name',
            'meters.user_id',
            'meters.metric_id',
            'meters.created_at',
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

    /**
     * Returns a new grid instance of the specified assets meter readings.
     *
     * @param int|string $id
     * @param int|string $meterId
     *
     * @return \Cartalyst\DataGrid\DataGrid
     */
    public function gridReadings($id, $meterId)
    {
        $columns = [
            'meter_readings.reading',
            'meter_readings.comment',
            'meter_readings.user_id',
            'meter_readings.created_at',
        ];

        $settings = [
            'sort'      => 'created_at',
            'direction' => 'desc',
        ];

        $transformer = function(MeterReading $reading) use ($id)
        {
            return [
                'id' => $reading->id,
                'reading' => $reading->reading,
                'comment' => $reading->comment,
                'user' => ($reading->user ? $reading->user->full_name : '<em>None</em>'),
                'created_at' => $reading->created_at,
            ];
        };

        return $this->asset->gridMeterReadings($id, $meterId, $columns, $settings, $transformer);
    }
}