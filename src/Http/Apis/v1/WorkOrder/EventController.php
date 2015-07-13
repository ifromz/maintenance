<?php

namespace Stevebauman\Maintenance\Http\Apis\v1\WorkOrder;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Apis\v1\EventableController;

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
