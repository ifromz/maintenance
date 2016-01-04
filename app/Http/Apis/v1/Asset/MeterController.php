<?php

namespace App\Http\Apis\v1\Asset;

use App\Http\Apis\v1\Controller as BaseController;
use App\Models\Meter;
use App\Models\MeterReading;
use App\Repositories\Asset\Repository as AssetRepository;

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
            'threshold' => 10,
            'throttle'  => 10,
        ];

        $transformer = function (Meter $meter) use ($id) {
            return [
                'id'         => $meter->id,
                'name'       => $meter->name,
                'user'       => ($meter->user ? $meter->user->full_name : '<em>None</em>'),
                'metric'     => ($meter->metric ? $meter->metric->name : '<em>None</em>'),
                'reading'    => $meter->getLastReadingWithMetricAttribute(),
                'comment'    => $meter->getLastCommentAttribute(),
                'created_at' => $meter->created_at,
                'view_url'   => route('maintenance.assets.meters.show', [$id, $meter->id]),
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
            'threshold' => 10,
            'throttle'  => 10,
        ];

        $transformer = function (MeterReading $reading) use ($id) {
            return [
                'id'         => $reading->id,
                'reading'    => $reading->reading,
                'comment'    => $reading->comment,
                'user'       => ($reading->user ? $reading->user->full_name : '<em>None</em>'),
                'created_at' => $reading->created_at,
            ];
        };

        return $this->asset->gridMeterReadings($id, $meterId, $columns, $settings, $transformer);
    }
}
