<?php

namespace App\Http\Apis\v1\Inventory;

use App\Http\Apis\v1\EventableController;
use App\Repositories\Inventory\Repository as InventoryRepository;
use Illuminate\Support\Facades\App;

class EventController extends EventableController
{
    /**
     * @var array
     */
    protected $routes = [
        'show' => 'maintenance.inventory.events.show',
    ];

    /**
     * @return InventoryRepository
     */
    protected function getEventableRepository()
    {
        return App::make(InventoryRepository::class);
    }

    /**
     * @return string
     */
    protected function getEventableCalendarId()
    {
        return config('maintenance.site.calendars.inventories');
    }
}
