@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_asset" data-toggle="tab">Profile</a></li>
                    <li class=""><a href="#tab_calendar" data-toggle="tab">Calendar</a></li>
                    <li class=""><a href="#tab_work_orders" data-toggle="tab">Work Orders</a></li>
                    <li class=""><a href="#tab_manuals" data-toggle="tab">Manuals</a></li>
                    <li class="dropdown pull-right">
       			<a href="#" class="text-muted dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i></a>
        		<ul class="dropdown-menu">
                            <li role="presentation">
                		<a role="menuitem" href="{{ route('maintenance.assets.images.index', array($asset->id)) }}"><i class="fa fa-search"></i> View Images</a>
                            </li>
                            <li role="presentation">
                		<a role="menuitem" href="{{ route('maintenance.assets.images.create', array($asset->id)) }}"><i class="fa fa-plus-circle"></i> Add Images</a>
                            </li>
                            <li class="divider"></li>
                            <li role="presentation">
                		<a role="menuitem" href="{{ route('maintenance.assets.edit', array($asset->id)) }}"><i class="fa fa-pencil"></i> Edit</a>
                            </li>
                            <li role="presentation">
                                <a data-method="delete" data-message="Are you sure you want to delete this asset? This will also remove all manuals." href="{{ route('maintenance.assets.destroy', array($asset->id)) }}" role="menuitem">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </li>
       			</ul>
                    </li>
		</ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_asset">
                    @include('maintenance::assets.tabs.asset', compact('asset'))
                </div>
                
                <div class="tab-pane" id="tab_calendar">
                    @include('maintenance::assets.calendar', compact('asset'))
                </div>

                <div class="tab-pane" id="tab_work_orders">
                    @include('maintenance::assets.tabs.work-orders', compact('asset'))
                </div>
                
                <div class="tab-pane" id="tab_manuals">
                    @include('maintenance::assets.tabs.manuals', compact('asset'))
                </div>
            </div>
	</div>

@stop