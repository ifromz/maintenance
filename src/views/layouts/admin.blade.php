@extends('maintenance::layouts.base')

@section('nav.left')

    @if(Sentry::hasAccess('maintenance.admin.dashboard.index'))
        <li class="{{ activeMenuLink('maintenance.admin.dashboard') }}">
            <a href="{{ route('maintenance.admin.dashboard.index') }}">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
        </li>
    @endif

    @if(Sentry::hasAccess('maintenance.admin.users.index'))
    <li class="{{ activeMenuLink('maintenance.admin.users') }}">
        <a href="{{ route('maintenance.admin.users.index') }}">
            <i class="fa fa-user"></i> Users
        </a>
    </li>
    @endif

    @if(Sentry::hasAccess('maintenance.admin.groups.index'))
    <li class="{{ activeMenuLink('maintenance.admin.groups') }}">
        <a href="{{ route('maintenance.admin.groups.index') }}">
            <i class="fa fa-users"></i> Groups
        </a>
    </li>
    @endif

    @if(Sentry::hasAccess('maintenance.admin.archive.index'))
    <li class="{{ activeMenuLink('maintenance.admin.archive') }} treeview">
        <a href="{{ route('maintenance.admin.archive.index') }}">
            <i class="fa fa-archive"></i> Archive
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li class="{{ activeMenuLink('maintenance.admin.archive.work-orders') }}">
                <a href="{{ route('maintenance.admin.archive.work-orders.index') }}">
                    <i class="fa fa-book"></i> Work Orders
                </a>
            </li>
            <li class="{{ activeMenuLink('maintenance.admin.archive.inventory') }}">
                <a href="{{ route('maintenance.admin.archive.inventory.index') }}">
                    <i class="fa fa-dropbox"></i> Inventory
                </a>
            </li>
            <li class="{{ activeMenuLink('maintenance.admin.archive.assets') }}">
                <a href="{{ route('maintenance.admin.archive.assets.index') }}">
                    <i class="fa fa-truck"></i> Assets
                </a>
            </li>
        </ul>
    </li>
    @endif

    @if(Sentry::hasAccess('maintenance.admin.settings.index'))
        <li class="{{ activeMenuLink('maintenance.admin.settings') }} treeview">
            <a href="#">
                <i class="fa fa-cogs"></i> Settings
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{ activeMenuLink('maintenance.admin.settings.site') }}">
                    <a href="{{ route('maintenance.admin.settings.site.index') }}">
                        <i class="fa fa-sitemap"></i> Site Settings
                    </a>
                </li>
                <li class="{{ activeMenuLink('maintenance.admin.settings.mail') }}">
                    <a href="{{ route('maintenance.admin.settings.mail.index') }}">
                        <i class="fa fa-envelope-o"></i> Mail Settings
                    </a>
                </li>
            </ul>
        </li>
    @endif
@stop