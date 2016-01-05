@extends('layouts.base')

@section('styles')
{!! HTML::style('assets/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
@stop

@section('nav.left')
    <li class="{{ active()->route('maintenance.dashboard.*') }}">
        <a href="{{ route('maintenance.dashboard.index') }}">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

    <li class="{{ active()->route('maintenance.events.*') }}">
        <a href="{{ route('maintenance.events.index') }}">
            <i class="fa fa-calendar"></i> Events
        </a>
    </li>

    <li class="{{ active()->route('maintenance.work-*') }} treeview">
        <a href="#">
            <i class="fa fa-wrench"></i> Maintenance
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">

            <li class="{{ active()->route('maintenance.work-requests.*') }}">
                <a href="{{ route('maintenance.work-requests.index') }}">
                    <i class="fa fa-exclamation-triangle"></i> Work Requests
                </a>
            </li>

            <li class="{{ active()->route('maintenance.work-orders.*') }}">
                <a href="{{ route('maintenance.work-orders.index') }}">
                    <i class="fa fa-briefcase"></i> Work Orders
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                <ul class="treeview-menu">
                    <li class="{{ active()->route('maintenance.work-orders.index') }}">
                        <a href="{{ route('maintenance.work-orders.index') }}">
                            <i class="fa fa-list"></i> All
                        </a>
                    </li>

                    <li class="{{ active()->route('maintenance.work-orders.assigned.*') }}">
                        <a href="{{ route('maintenance.work-orders.assigned.index') }}">
                            <i class="fa fa-user"></i> Assigned
                        </a>
                    </li>

                    <li class="{{ active()->route('maintenance.work-orders.statuses.*') }}">
                        <a href="{{ route('maintenance.work-orders.statuses.index') }}">
                            <i class="fa fa-info"></i> Statuses
                        </a>
                    </li>

                    <li class="{{ active()->route('maintenance.work-orders.priorities.*') }}">
                        <a href="{{ route('maintenance.work-orders.priorities.index') }}">
                            <i class="fa fa-exclamation-circle"></i> Priorities
                        </a>
                    </li>

                    <li class="{{ active()->route('maintenance.work-orders.categories.*') }}">
                        <a href="{{ route('maintenance.work-orders.categories.index') }}">
                            <i class="fa fa-folder"></i> Categories
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </li>

    <li class="{{ active()->route('maintenance.inventory.*') }} treeview">
        <a href="#">
            <i class="fa fa-dropbox"></i> Inventory
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">

            <li class="{{ active()->route('maintenance.inventory') }}">
                <a href="{{ route('maintenance.inventory.index') }}">
                    <i class="fa fa-list"></i> All Items
                </a>
            </li>


            <li class="{{ active()->route('maintenance.inventory.categories') }}">
                <a href="{{ route('maintenance.inventory.categories.index') }}">
                    <i class="fa fa-folder"></i> Categories
                </a>
            </li>

        </ul>
    </li>

    <li class="{{ active()->route('maintenance.assets.*') }} treeview">
        <a href="#">
            <i class="fa fa-truck"></i> Assets
            <i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="treeview-menu">
            <li class="{{ active()->route('maintenance.assets') }}">
                <a href="{{ route('maintenance.assets.index') }}">
                    <i class="fa fa-list"></i> All Assets
                </a>
            </li>
            <li class="{{ active()->route('maintenance.assets.categories') }}">
                <a href="{{ route('maintenance.assets.categories.index') }}">
                    <i class="fa fa-folder"></i> Categories
                </a>
            </li>
        </ul>

    </li>

    <li class="{{ active()->route('maintenance.locations.*') }}">
        <a href="{{ route('maintenance.locations.index') }}">
            <i class="fa fa-location-arrow"></i> Locations
        </a>
    </li>

    <li class="{{ active()->route('maintenance.work-requests.*') }}">
        <a href="{{ route('maintenance.work-requests.index') }}">
            <i class="fa fa-book"></i>
            My Work Requests
        </a>
    </li>

    <li class="{{ active()->route('maintenance.metrics.*') }}">
        <a href="{{ route('maintenance.metrics.index') }}">
            <i class="fa fa-anchor"></i>
            Metrics
        </a>
    </li>
@stop

@section('scripts')
    <!-- Bootstrap Date Range Picker -->
    {!! HTML::script('assets/bootstrap-daterangepicker/daterangepicker.js') !!}
@stop
