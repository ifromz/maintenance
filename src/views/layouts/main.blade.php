@extends('maintenance::layouts.base')

@section('nav.left')

    @if(Sentry::hasAccess('maintenance.dashboard.index'))
        <li class="{{ activeMenuLink('maintenance.dashboard') }} treeview">
            <a href="{{ route('maintenance.dashboard.index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('maintenance.dashboard.index') }}" style="margin-left: 10px;">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="#" style="margin-left: 10px;">
                        <i class="fa fa-calendar"></i> Calendar
                    </a>
                </li>

                <li>
                    <a href="{{ route('maintenance.work-orders.assigned.index') }}" style="margin-left: 10px;">
                        <i class="fa fa-book"></i> Assigned Work Orders
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if(Sentry::hasAccess('maintenance.events.index'))
        <li class="{{ activeMenuLink('maintenance.events') }}">
            <a href="{{ route('maintenance.events.index') }}">
                <i class="fa fa-calendar"></i> Generic Events
            </a>
        </li>
    @endif

    @if(Sentry::hasAccess('maintenance.work-orders.index'))
        <li class="{{ activeMenuLink('maintenance.work-orders') }} treeview">
            <a href="#">
                <i class="fa fa-wrench"></i> Maintenance
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">

                @if(Sentry::hasAccess('maintenance.work-requests.index'))
                    <li class="{{ activeMenuLink('maintenance.work-requests.index') }}">
                        <a href="{{ route('maintenance.work-requests.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-exclamation-triangle"></i> Work Requests
                        </a>
                    </li>
                @endif

                @if(Sentry::hasAccess('maintenance.work-orders.index'))
                    <li class="{{ activeMenuLink('maintenance.work-orders.index') }}">
                        <a href="{{ route('maintenance.work-orders.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-book"></i> Work Orders
                        </a>
                    </li>
                @endif

                <li>
                    <a href="#" style="margin-left: 10px;">
                        <i class="fa fa-refresh"></i> Scheduled Maintenance
                    </a>
                </li>

                @if(Sentry::hasAccess('maintenance.work-orders.statuses.index'))
                    <li class="{{ activeMenuLink('maintenance.work-orders.statuses') }}">
                        <a href="{{ route('maintenance.work-orders.statuses.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-info"></i> Statuses
                        </a>
                    </li>
                @endif

                @if(Sentry::hasAccess('maintenance.work-orders.priorities.index'))
                    <li class="{{ activeMenuLink('maintenance.work-orders.priorities') }}">
                        <a href="{{ route('maintenance.work-orders.priorities.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-exclamation-circle"></i> Priorities
                        </a>
                    </li>
                @endif

                @if(Sentry::hasAccess('maintenance.work-orders.categories.index'))
                    <li class="{{ activeMenuLink('maintenance.work-orders.categories') }}">
                        <a href="{{ route('maintenance.work-orders.categories.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-folder"></i> Categories
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(Sentry::hasAccess('maintenance.inventory.index'))
        <li class="{{ activeMenuLink('maintenance.inventory') }} treeview">
            <a href="#">
                <i class="fa fa-dropbox"></i> Inventory
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @if(Sentry::hasAccess('maintenance.inventory.index'))
                    <li class="{{ activeMenuLink('maintenance.inventory.index') }}">
                        <a href="{{ route('maintenance.inventory.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-gears"></i> All Items
                        </a>
                    </li>
                @endif

                @if(Sentry::hasAccess('maintenance.inventory.categories.index'))
                    <li class="{{ activeMenuLink('maintenance.inventory.categories') }}">
                        <a href="{{ route('maintenance.inventory.categories.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-folder"></i> Categories
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(Sentry::hasAccess('maintenance.assets.index'))
        <li class="{{ activeMenuLink('maintenance.assets') }} treeview">
            <a href="#">
                <i class="fa fa-truck"></i> Assets
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{ activeMenuLink('maintenance.assets.index') }}">
                    <a href="{{ route('maintenance.assets.index') }}" style="margin-left: 10px;">
                        <i class="fa fa-book"></i> All Assets
                    </a>
                </li>
                @if(Sentry::hasAccess('maintenance.assets.categories.index'))
                    <li class="{{ activeMenuLink('maintenance.assets.categories') }}">
                        <a href="{{ route('maintenance.assets.categories.index') }}" style="margin-left: 10px;">
                            <i class="fa fa-folder"></i> Categories
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if(Sentry::hasAccess('maintenance.locations.index'))
        <li class="{{ activeMenuLink('maintenance.locations') }}">
            <a href="{{ route('maintenance.locations.index') }}">
                <i class="fa fa-location-arrow"></i> Locations
            </a>
        </li>
    @endif

    @if(!Sentry::hasAccess('maintenance.dashboard.index'))
        <li class="{{ activeMenuLink('maintenance.work-requests') }}">
            <a href="{{ route('maintenance.work-requests.index') }}">
                <i class="fa fa-book"></i>
                My Work Requests
            </a>
        </li>
    @endif

    @if(Sentry::hasAccess('maintenance.metrics.index'))
        <li class="{{ activeMenuLink('maintenance.metrics') }}">
            <a href="{{ route('maintenance.metrics.index') }}">
                <i class="fa fa-anchor"></i>
                Metrics
            </a>
        </li>
    @endif

@stop