<?php

namespace Stevebauman\Maintenance\Repositories\Asset;

use Stevebauman\Maintenance\Http\Requests\Asset\MeterRequest;
use Stevebauman\Maintenance\Models\Meter;
use Stevebauman\Maintenance\Services\SentryService;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class MeterRepository extends BaseRepository
{
    /**
     * @var Repository
     */
    protected $asset;

    /**
     * @var SentryService
     */
    protected $sentry;

    /**
     * Constructor.
     *
     * @param Repository    $asset
     * @param SentryService $sentry
     */
    public function __construct(AssetRepository $asset, SentryService $sentry)
    {
        $this->asset = $asset;
        $this->sentry = $sentry;
    }

    /**
     * @return Meter
     */
    public function model()
    {
        return new Meter();
    }

    /**
     * Creates a new asset meter.
     *
     * @param MeterRequest $request
     * @param int|string   $id
     *
     * @return bool|Meter
     */
    public function create(MeterRequest $request, $id)
    {
        $asset = $this->asset->find($id);

        if($asset) {
            $meter = $this->model();

            $meter->user_id = $this->sentry->getCurrentUserId();
            $meter->metric_id = $request->input('metric');
            $meter->name = $request->input('name');

            if($meter->save()) {
                $asset->meters()->attach($meter);

                $reading = [
                    'user_id' => $this->sentry->getCurrentUserId(),
                    'reading' => $request->input('reading'),
                    'comment' => $request->input('comment'),
                ];

                $meter->readings()->create($reading);

                return $meter;
            }
        }

        return false;
    }

    /**
     * Updates an asset meter.
     *
     * @param MeterRequest $request
     * @param int|string   $id
     * @param int|string   $meterId
     *
     * @return bool|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function update(MeterRequest $request, $id, $meterId)
    {
        $asset = $this->asset->model()->findOrFail($id);

        $meter = $asset->meters()->find($meterId);

        if($meter) {
            $meter->metric_id = $request->input('metric');
            $meter->name = $request->input('name');

            if($meter->save()) {
                $reading = [
                    'user_id' => $this->sentry->getCurrentUserId(),
                    'reading' => $request->input('reading'),
                    'comment' => $request->input('comment'),
                ];

                $meter->readings()->create($reading);

                return $meter;
            }
        }

        return false;
    }
}
