@extends('maintenance::layouts.base')

@section('styles')
{!! HTML::style('assets/stevebauman/maintenance/resources/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
@stop

@section('nav.left')

    @if($currentUser->hasAccess('maintenance.dashboard.index'))
        <li class="{{ activeMenuLink('maintenance.dashboard') }} treeview">
            <a href="{{ route('maintenance.dashboard.index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ route('maintenance.dashboard.index') }}">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fa fa-calendar"></i> Calendar
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if($currentUser->hasAccess('maintenance.events.index'))
        <li class="{{ activeMenuLink('maintenance.events') }}">
            <a href="{{ route('maintenance.events.index') }}">
                <i class="fa fa-calendar"></i> Events
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess('maintenance.work-orders.index'))
        <li class="{{ activeMenuLink('maintenance.work-') }} treeview">
            <a href="#">
                <i class="fa fa-wrench"></i> Maintenance
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">

                @if($currentUser->hasAccess('maintenance.work-requests.index'))
                    <li class="{{ activeMenuLink('maintenance.work-requests') }}">
                        <a href="{{ route('maintenance.work-requests.index') }}">
                            <i class="fa fa-exclamation-triangle"></i> Work Requests
                        </a>
                    </li>
                @endif

                @if($currentUser->hasAccess('maintenance.work-orders.*'))
                    <li class="{{ activeMenuLink('maintenance.work-orders') }}">
                        <a href="{{ route('maintenance.work-orders.index') }}">
                            <i class="fa fa-briefcase"></i> Work Orders
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>

                        <ul class="treeview-menu">

                            @if($currentUser->hasAccess('maintenance.work-orders.index'))
                                <li class="{{ activeMenuLink('maintenance.work-orders.index') }}">
                                    <a href="{{ route('maintenance.work-orders.index') }}">
                                        <i class="fa fa-list"></i> All
                                    </a>
                                </li>
                            @endif

                            <li class="{{ activeMenuLink('maintenance.work-orders.assigned') }}">
                                <a href="{{ route('maintenance.work-orders.assigned.index') }}">
                                    <i class="fa fa-user"></i> Assigned
                                </a>
                            </li>

                            @if($currentUser->hasAccess('maintenance.work-orders.statuses.index'))
                                <li class="{{ activeMenuLink('maintenance.work-orders.statuses') }}">
                                    <a href="{{ route('maintenance.work-orders.statuses.index') }}">
                                        <i class="fa fa-info"></i> Statuses
                                    </a>
                                </li>
                            @endif

                            @if($currentUser->hasAccess('maintenance.work-orders.priorities.index'))
                                <li class="{{ activeMenuLink('maintenance.work-orders.priorities') }}">
                                    <a href="{{ route('maintenance.work-orders.priorities.index') }}">
                                        <i class="fa fa-exclamation-circle"></i> Priorities
                                    </a>
                                </li>
                            @endif

                            @if($currentUser->hasAccess('maintenance.work-orders.categories.index'))
                                <li class="{{ activeMenuLink('maintenance.work-orders.categories') }}">
                                    <a href="{{ route('maintenance.work-orders.categories.index') }}">
                                        <i class="fa fa-folder"></i> Categories
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
        </li>
    @endif

    @if($currentUser->hasAccess('maintenance.inventory.index'))
        <li class="{{ activeMenuLink('maintenance.inventory') }} treeview">
            <a href="#">
                <i class="fa fa-dropbox"></i> Inventory
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @if($currentUser->hasAccess('maintenance.inventory.index'))
                    <li class="{{ activeMenuLink('maintenance.inventory') }}">
                        <a href="{{ route('maintenance.inventory.index') }}">
                            <i class="fa fa-list"></i> All Items
                        </a>
                    </li>
                @endif

                @if($currentUser->hasAccess('maintenance.inventory.categories.index'))
                    <li class="{{ activeMenuLink('maintenance.inventory.categories') }}">
                        <a href="{{ route('maintenance.inventory.categories.index') }}">
                            <i class="fa fa-folder"></i> Categories
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if($currentUser->hasAccess('maintenance.assets.index'))
        <li class="{{ activeMenuLink('maintenance.assets') }} treeview">
            <a href="#">
                <i class="fa fa-truck"></i> Assets
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{ activeMenuLink('maintenance.assets') }}">
                    <a href="{{ route('maintenance.assets.index') }}">
                        <i class="fa fa-list"></i> All Assets
                    </a>
                </li>
                @if($currentUser->hasAccess('maintenance.assets.categories.index'))
                    <li class="{{ activeMenuLink('maintenance.assets.categories') }}">
                        <a href="{{ route('maintenance.assets.categories.index') }}">
                            <i class="fa fa-folder"></i> Categories
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if($currentUser->hasAccess('maintenance.locations.index'))
        <li class="{{ activeMenuLink('maintenance.locations') }}">
            <a href="{{ route('maintenance.locations.index') }}">
                <i class="fa fa-location-arrow"></i> Locations
            </a>
        </li>
    @endif

    @if(!$currentUser->hasAccess('maintenance.dashboard.index'))
        <li class="{{ activeMenuLink('maintenance.work-requests') }}">
            <a href="{{ route('maintenance.work-requests.index') }}">
                <i class="fa fa-book"></i>
                My Work Requests
            </a>
        </li>
    @endif

    @if($currentUser->hasAccess('maintenance.metrics.index'))
        <li class="{{ activeMenuLink('maintenance.metrics') }}">
            <a href="{{ route('maintenance.metrics.index') }}">
                <i class="fa fa-anchor"></i>
                Metrics
            </a>
        </li>
    @endif

@stop

@section('scripts')

    {!! HTML::script('assets/cartalyst/data-grid/js/data-grid.js') !!}
    {!! HTML::script('assets/cartalyst/data-grid/js/underscore.js') !!}

    <!-- Bootstrap Date Range Picker -->
    {!! HTML::script('assets/stevebauman/maintenance/resources/bootstrap-daterangepicker/daterangepicker.js') !!}

    {!! HTML::script('assets/stevebauman/maintenance/js/grid.js') !!}
@stop
