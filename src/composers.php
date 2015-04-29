<?php

/**
 * The Maintenance View Composers registration file
 */

use Illuminate\Support\Facades\View;

View::composers([
    'Stevebauman\Maintenance\Composers\MainLayoutComposer'      => 'maintenance::layouts.main',
    'Stevebauman\Maintenance\Composers\PublicLayoutComposer'    => 'maintenance::layouts.public',
    'Stevebauman\Maintenance\Composers\AdminLayoutComposer'     => 'maintenance::layouts.admin',
    'Stevebauman\Maintenance\Composers\AdminDashboardComposer'  => 'maintenance::admin.dashboard.index',
    'Stevebauman\Maintenance\Composers\MainNotificationComposer' => 'maintenance::layouts.partials.notifications',
    'Stevebauman\Maintenance\Composers\AssetSelectComposer'     => 'maintenance::select.assets',
    'Stevebauman\Maintenance\Composers\InventorySelectComposer' => 'maintenance::select.inventories',
    'Stevebauman\Maintenance\Composers\WorkOrderSelectComposer' => 'maintenance::select.work-orders',
    'Stevebauman\Maintenance\Composers\StatusSelectComposer'    => 'maintenance::select.status',
    'Stevebauman\Maintenance\Composers\PrioritySelectComposer'  => 'maintenance::select.priority',
    'Stevebauman\Maintenance\Composers\UserSelectComposer'      => 'maintenance::select.users',
    'Stevebauman\Maintenance\Composers\RouteSelectComposer'     => 'maintenance::select.routes',
    'Stevebauman\Maintenance\Composers\GroupSelectComposer'     => 'maintenance::select.groups',
    'Stevebauman\Maintenance\Composers\MetricSelectComposer'    => 'maintenance::select.metric',
]);