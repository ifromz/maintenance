<?php

/*
 * Main Layout Composer
 */
View::composer('maintenance::layouts.main', 'Stevebauman\Maintenance\Composers\MainLayoutComposer');

/*
 * Admin Layout Composer
 */
View::composer('maintenance::layouts.admin', 'Stevebauman\Maintenance\Composers\AdminLayoutComposer');

View::composer('maintenance::admin.dashboard.index', 'Stevebauman\Maintenance\Composers\AdminDashboardComposer');

/*
 * Notifications Composer
 */
View::composer('maintenance::layouts.partials.notifications', 'Stevebauman\Maintenance\Composers\MainNotificationComposer');

/*
 * Public Layout Composer
 */
View::composer('maintenance::layouts.public', 'Stevebauman\Maintenance\Composers\PublicLayoutComposer');

/*
 * Select Composers
 */
View::composer('maintenance::select.assets', 'Stevebauman\Maintenance\Composers\AssetSelectComposer');

View::composer('maintenance::select.inventories', 'Stevebauman\Maintenance\Composers\InventorySelectComposer');

View::composer('maintenance::select.work-orders', 'Stevebauman\Maintenance\Composers\WorkOrderSelectComposer');

View::composer('maintenance::select.status', 'Stevebauman\Maintenance\Composers\StatusSelectComposer');

View::composer('maintenance::select.priority', 'Stevebauman\Maintenance\Composers\PrioritySelectComposer');

View::composer('maintenance::select.users', 'Stevebauman\Maintenance\Composers\UserSelectComposer');

View::composer('maintenance::select.routes', 'Stevebauman\Maintenance\Composers\RouteSelectComposer');

View::composer('maintenance::select.metric', 'Stevebauman\Maintenance\Composers\MetricSelectComposer');