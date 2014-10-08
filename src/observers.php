<?php

/*
 * Observer Registrations
 */

Stevebauman\Maintenance\Models\WorkOrder::observe(new Stevebauman\Maintenance\Observers\WorkOrderObserver);
Stevebauman\Maintenance\Models\WorkOrderAssignment::observe(new Stevebauman\Maintenance\Observers\WorkOrderAssignmentObserver);

Stevebauman\Maintenance\Models\InventoryStock::observe(new Stevebauman\Maintenance\Observers\InventoryStockObserver);