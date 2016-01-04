<?php

namespace App\Providers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * The view composers to register.
     *
     * @var array
     */
    protected $composers = [
        \App\Composers\AdminDashboardComposer::class   => 'admin.dashboard.index',
        \App\Composers\MainNotificationComposer::class => 'layouts.partials.notifications',
        \App\Composers\AssetSelectComposer::class      => 'select.assets',
        \App\Composers\InventorySelectComposer::class  => 'select.inventories',
        \App\Composers\WorkOrderSelectComposer::class  => 'select.work-orders',
        \App\Composers\StatusSelectComposer::class     => 'select.status',
        \App\Composers\PrioritySelectComposer::class   => 'select.priority',
        \App\Composers\UserSelectComposer::class       => 'select.users',
        \App\Composers\RouteSelectComposer::class      => 'select.routes',
        \App\Composers\RoleSelectComposer::class       => 'select.roles',
        \App\Composers\MetricSelectComposer::class     => 'select.metric',
    ];

    /**
     * Registers view composers during boot.
     *
     * @param Factory $view
     */
    public function boot(Factory $view)
    {
        foreach ($this->composers as $callback => $views) {
            $view->composer($views, $callback);
        }
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
