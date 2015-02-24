@extends('maintenance::layouts.pages.main.tabbed')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('tab.head.content')
    <li class="active"><a href="#tab_asset" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_history" data-toggle="tab">History</a></li>
    <li><a href="#tab_meters" data-toggle="tab">Meters & Readings</a></li>
    <li><a href="#tab_calendar" data-toggle="tab">Calendar</a></li>
    <li><a href="#tab_work_orders" data-toggle="tab">Work Orders</a></li>
    <li><a href="#tab_manuals" data-toggle="tab">Manuals</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_asset">

        <legend>Profile</legend>

        {{ $asset->viewer()->btnQrCode }}

        {{ $asset->viewer()->btnEvents }}

        {{ $asset->viewer()->btnAddImages }}

        {{ $asset->viewer()->btnViewImages }}

        {{ $asset->viewer()->btnEdit }}

        {{ $asset->viewer()->btnDelete }}

        <hr>

        <div class="col-md-9">
            {{ $asset->viewer()->profile }}
        </div>

        <div class="col-md-3">
            {{ $asset->viewer()->slideshow }}
        </div>

        <div class="clearfix"></div>

    </div>

    <div class="tab-pane" id="tab_meters">

        <legend>Meters & Readings</legend>

        {{ $asset->viewer()->btnAddMeter }}

        <hr>

        {{ $asset->viewer()->meters }}

    </div>

    <div class="tab-pane" id="tab_history">
        {{ $asset->viewer()->history }}
    </div>

    <div class="tab-pane" id="tab_calendar">
        <legend>Calendar</legend>

        {{ $asset->viewer()->calendar }}
    </div>

    <div class="tab-pane" id="tab_work_orders">

        <legend>Work Orders</legend>

        {{ $asset->viewer()->workOrders($workOrders) }}

    </div>

    <div class="tab-pane" id="tab_manuals">
        <legend>Manuals</legend>

        {{ $asset->viewer()->btnAddManuals }}

        <hr>

        {{ $asset->viewer()->manuals }}

    </div>

@stop