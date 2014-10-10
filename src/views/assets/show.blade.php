@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.assets.index') }}">
        <i class="fa fa-truck"></i> 
        Assets
    </a>
</li>
<li class="active">
    {{ $asset->name }}
</li>
@stop

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_asset" data-toggle="tab">Profile</a></li>
            <li class=""><a href="#tab_calendar" data-toggle="tab">Calendar</a></li>
            <li class=""><a href="#tab_work_orders" data-toggle="tab">Work Orders</a></li>
            <li class=""><a href="#tab_manuals" data-toggle="tab">Manuals</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_asset">
                @include('maintenance::assets.tabs.profile', array('asset'=>$asset))
            </div>

            <div class="tab-pane" id="tab_calendar">
                @include('maintenance::assets.tabs.calendar', array('asset'=>$asset))
            </div>

            <div class="tab-pane" id="tab_work_orders">
                @include('maintenance::assets.tabs.work-orders', array('asset'=>$asset))
            </div>

            <div class="tab-pane" id="tab_manuals">
                @include('maintenance::assets.tabs.manuals', array('asset'=>$asset))
            </div>
        </div>
    </div>
@stop