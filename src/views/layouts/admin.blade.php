@extends('maintenance::layouts.base')

@section('nav.left')

    <li>
        <a href="{{ route('maintenance.admin.users.index') }}">
            <i class="fa fa-user"></i> Users
        </a>
    </li>

    <li>
        <a href="{{ route('maintenance.admin.groups.index') }}">
            <i class="fa fa-users"></i> Groups
        </a>
    </li>

    <li class="treeview">
        <a href="{{ route('maintenance.admin.archive.index') }}">
            <i class="fa fa-archive"></i> Archive
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a href="{{ route('maintenance.admin.archive.work-orders.index') }}" style="margin-left: 10px;">
                    <i class="fa fa-book"></i> Work Orders
                </a>
            </li>
            <li>
                <a href="{{ route('maintenance.admin.archive.inventory.index') }}" style="margin-left: 10px;">
                    <i class="fa fa-dropbox"></i> Inventory
                </a>
            </li>
            <li>
                <a href="{{ route('maintenance.admin.archive.assets.index') }}" style="margin-left: 10px;">
                    <i class="fa fa-truck"></i> Assets
                </a>
            </li>
        </ul>
    </li>

@stop