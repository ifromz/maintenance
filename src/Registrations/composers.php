<?php

/**
 * The Maintenance View Composers registration file.
 */
use Illuminate\Support\Facades\View;

View::composers([
    \Stevebauman\Maintenance\Composers\ClientLayoutComposer::class     => 'maintenance::layouts.client',
    \Stevebauman\Maintenance\Composers\MainLayoutComposer::class       => 'maintenance::layouts.main',
    \Stevebauman\Maintenance\Composers\PublicLayoutComposer::class     => 'maintenance::layouts.public',
    \Stevebauman\Maintenance\Composers\AdminLayoutComposer::class      => 'maintenance::layouts.admin',
    \Stevebauman\Maintenance\Composers\AdminDashboardComposer::class   => 'maintenance::admin.dashboard.index',
    \Stevebauman\Maintenance\Composers\MainNotificationComposer::class => 'maintenance::layouts.partials.notifications',
    \Stevebauman\Maintenance\Composers\AssetSelectComposer::class      => 'maintenance::select.assets',
    \Stevebauman\Maintenance\Composers\InventorySelectComposer::class  => 'maintenance::select.inventories',
    \Stevebauman\Maintenance\Composers\WorkOrderSelectComposer::class  => 'maintenance::select.work-orders',
    \Stevebauman\Maintenance\Composers\StatusSelectComposer::class     => 'maintenance::select.status',
    \Stevebauman\Maintenance\Composers\PrioritySelectComposer::class   => 'maintenance::select.priority',
    \Stevebauman\Maintenance\Composers\UserSelectComposer::class       => 'maintenance::select.users',
    \Stevebauman\Maintenance\Composers\RouteSelectComposer::class      => 'maintenance::select.routes',
    \Stevebauman\Maintenance\Composers\RoleSelectComposer::class       => 'maintenance::select.roles',
    \Stevebauman\Maintenance\Composers\MetricSelectComposer::class     => 'maintenance::select.metric',
]);
