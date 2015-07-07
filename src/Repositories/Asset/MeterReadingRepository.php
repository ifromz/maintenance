<?php

namespace Stevebauman\Maintenance\Repositories\Asset;

use Stevebauman\Maintenance\Models\MeterReading;
use Stevebauman\Maintenance\Repositories\Repository as BaseRepository;

class MeterReadingRepository extends BaseRepository
{
    /**
     * @return MeterReading
     */
    public function model()
    {
        return new MeterReading();
    }
}
