<?php

namespace App\Http\Apis\v1\Asset;

use Illuminate\Support\Facades\App;
use App\Http\Apis\v1\EventableController;
use App\Repositories\Asset\Repository as AssetRepository;

class EventController extends EventableController
{
    /**
     * @var array
     */
    protected $routes = [
        'show' => 'maintenance.assets.events.show',
    ];

    /**
     * @return AssetRepository
     */
    protected function getEventableRepository()
    {
        return App::make(AssetRepository::class);
    }

    /**
     * @return string
     */
    protected function getEventableCalendarId()
    {
        return config('maintenance.site.calendars.assets');
    }
}
