<?php

namespace Stevebauman\Maintenance\Controllers\Asset\Meter;

use Stevebauman\Maintenance\Validators\MeterValidator;
use Stevebauman\Maintenance\Services\Meter\ReadingService;
use Stevebauman\Maintenance\Services\Meter\MeterService;
use Stevebauman\Maintenance\Services\Asset\AssetService;
use Stevebauman\Maintenance\Controllers\BaseController;

/*
 * Handles asset meter creation and updating
 */
class MeterController extends BaseController
{
    /**
     * @var AssetService
     */
    protected $asset;

    /**
     * @var MeterService
     */
    protected $meter;

    /**
     * @var ReadingService
     */
    protected $meterReading;

    /**
     * @var MeterValidator
     */
    protected $meterValidator;

    /**
     * @param AssetService   $asset
     * @param MeterService   $meter
     * @param ReadingService $meterReading
     * @param MeterValidator $meterValidator
     */
    public function __construct(
            AssetService $asset,
            MeterService $meter,
            ReadingService $meterReading,
            MeterValidator $meterValidator)
    {
        $this->asset = $asset;
        $this->meter = $meter;
        $this->meterReading = $meterReading;
        $this->meterValidator = $meterValidator;
    }

    /**
     * Creates a meter and attaches it to the asset.
     *
     * @param int $asset_id
     *
     * @return response
     */
    public function store($asset_id)
    {
        if ($this->meterValidator->passes()) {

            /*
             * Find the asset
             */
            $asset = $this->asset->find($asset_id);

            /*
             * Create the meter
             */
            $meter = $this->meter->setInput($this->inputAll())->create();

            /*
             * If the meter has been created
             */
            if ($meter) {
                /*
                 * Attach the meter to the asset
                 */
                $asset->meters()->attach($meter);

                /*
                 * Set the data for the meter reading
                 */
                $data = $this->inputAll();
                $data['meter_id'] = $meter->id;

                /*
                 * Create the meter reading
                 */
                $this->meterReading->setInput($data)->create();

                $this->message = 'Successfully created meter reading';
                $this->messageType = 'success';
                $this->redirect = route('maintenance.assets.show', [$asset->id]);
            } else {
                $this->message = 'There was an error trying to create a meter for this asset. Please try again';
                $this->messageType = 'danger';
                $this->redirect = route('maintenance.assets.show', [$asset->id]);
            }
        } else {
            $this->redirect = route('maintenance.assets.meters.show', [$asset_id]);
            $this->errors = $this->meterValidator->getErrors();
        }

        return $this->response();
    }

    /**
     * Displays the specified meter and it's readings.
     *
     * @param int $asset_id
     * @param int $meter_id
     */
    public function show($asset_id, $meter_id)
    {
        $asset = $this->asset->find($asset_id);

        $meter = $this->meter->find($meter_id);

        $readings = $this->meterReading->getByMeterByPageWithFilter($meter->id);

        return view('maintenance::assets.meters.show', [
            'title' => 'Viewing Asset Meter: '.$meter->name,
            'asset' => $asset,
            'meter' => $meter,
            'readings' => $readings,
        ]);
    }

    public function edit($asset_id, $meter_id)
    {
        $asset = $this->asset->find($asset_id);

        $meter = $this->meter->find($meter_id);

        return view('maintenance::assets.meters.edit', [
            'title' => 'Editing Asset Meter: '.$meter->name,
            'asset' => $asset,
            'meter' => $meter,
        ]);
    }

    public function update($asset_id, $meter_id)
    {
        if ($this->meterValidator->passes()) {
            $asset = $this->asset->find($asset_id);

            $data = $this->inputAll();
            $data['asset_id'] = $asset->id;

            $this->meter->setInput($data)->update($meter_id);

            $this->message = 'Successfully updated meter';
            $this->messageType = 'success';
            $this->redirect = route('maintenance.assets.show', [$asset_id]);
        } else {
            $this->errors = $this->meterValidator->getErrors();
            $this->redirect = route('maintenance.assets.meters.edit', [$asset_id, $meter_id]);
        }

        return $this->response();
    }

    public function destroy($asset_id, $meter_id)
    {
        $asset = $this->asset->find($asset_id);

        $this->meter->destroy($meter_id);

        $this->message = 'Successfully deleted meter';
        $this->messageType = 'success';
        $this->redirect = route('maintenance.assets.show', [$asset->id]);

        return $this->response();
    }
}
