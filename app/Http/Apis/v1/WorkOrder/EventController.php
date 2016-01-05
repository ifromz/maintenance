<?php

namespace App\Http\Apis\v1\WorkOrder;

use App\Http\Apis\v1\EventableController;
use App\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Illuminate\Support\Facades\App;

class EventController extends EventableController
{
    /**
     * @var array
     */
    protected $routes = [
        'show' => 'maintenance.work-orders.events.show',
    ];

    /**
     * @return WorkOrderRepository
     */
    protected function getEventableRepository()
    {
        return App::make(WorkOrderRepository::class);
    }

    /**
     * @return string
     */
    protected function getEventableCalendarId()
    {
        return config('maintenance.site.calendars.work-orders');
    }
}
