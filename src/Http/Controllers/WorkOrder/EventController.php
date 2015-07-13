<?php

namespace Stevebauman\Maintenance\Http\Controllers\WorkOrder;

use Illuminate\Support\Facades\App;
use Stevebauman\Maintenance\Repositories\WorkOrder\Repository as WorkOrderRepository;
use Stevebauman\Maintenance\Http\Controllers\Event\EventableController;

class EventController extends EventableController
{
    /**
     * @var array
     */
    protected $routes = [
        'index' => 'maintenance.work-orders.events.index',
        'create' => 'maintenance.work-orders.events.create',
        'store' => 'maintenance.work-orders.events.store',
        'show' => 'maintenance.work-orders.events.show',
        'edit' => 'maintenance.work-orders.events.edit',
        'update' => 'maintenance.work-orders.events.update',
        'destroy' => 'maintenance.work-orders.events.destroy',
        'grid' => 'maintenance.api.v1.work-orders.events.grid',
    ];

    /**
     * @return WorkOrderRepository
     */
    protected function getEventableRepository()
    {
        return App::make(WorkOrderRepository::class);
    }
}
