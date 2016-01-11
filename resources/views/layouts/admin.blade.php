@extends('layouts.base')

@section('styles')
{!! HTML::style('assets/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
@endsection

@section('nav.left')

    <li class="{{ active()->route('maintenance.admin.dashboard') }}">
        <a href="{{ route('maintenance.admin.dashboard.index') }}">
            <i class="fa fa-dashboard"></i> Dashboard
        </a>
    </li>

    <li class="{{ active()->route('maintenance.admin.users') }}">
        <a href="{{ route('maintenance.admin.users.index') }}">
            <i class="fa fa-user"></i> Users
        </a>
    </li>

    <li class="{{ active()->route('maintenance.admin.roles') }}">
        <a href="{{ route('maintenance.admin.roles.index') }}">
            <i class="fa fa-users"></i> Roles
        </a>
    </li>

    <li class="{{ active()->route('maintenance.admin.archive') }} treeview">
        <a href="#">
            <i class="fa fa-archive"></i> Archive
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="{{ active()->route('maintenance.admin.archive.work-orders') }}">
                <a href="{{ route('maintenance.admin.archive.work-orders.index') }}">
                    <i class="fa fa-book"></i> Work Orders
                </a>
            </li>
            <li class="{{ active()->route('maintenance.admin.archive.inventory') }}">
                <a href="{{ route('maintenance.admin.archive.inventory.index') }}">
                    <i class="fa fa-dropbox"></i> Inventory
                </a>
            </li>
            <li class="{{ active()->route('maintenance.admin.archive.assets') }}">
                <a href="{{ route('maintenance.admin.archive.assets.index') }}">
                    <i class="fa fa-truck"></i> Assets
                </a>
            </li>
        </ul>
    </li>

    <li class="{{ active()->route('maintenance.admin.settings') }} treeview">
        <a href="#">
            <i class="fa fa-cogs"></i> Settings
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="{{ active()->route('maintenance.admin.settings.site') }}">
                <a href="{{ route('maintenance.admin.settings.site.index') }}">
                    <i class="fa fa-sitemap"></i> Site Settings
                </a>
            </li>
        </ul>
    </li>

    <li class="{{ active()->route('maintenance.admin.logs') }}">
        <a href="{{ route('maintenance.admin.logs.index') }}">
            <i class="fa fa-list-alt"></i> Site Log
        </a>
    </li>
@endsection

@section('scripts')

    {!! HTML::script('assets/cartalyst/data-grid/js/underscore.js') !!}

    <!-- Bootstrap Date Range Picker -->
    {!! HTML::script('assets/bootstrap-daterangepicker/daterangepicker.js') !!}

@endsection
