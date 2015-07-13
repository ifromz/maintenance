<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\Asset;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Repositories\Asset\Repository as AssetRepository;
use Stevebauman\Maintenance\Http\Apis\v1\EventableController;

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
