<?php

namespace App\Repositories\Asset;

use App\Models\MeterReading;
use App\Repositories\Repository as BaseRepository;

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
