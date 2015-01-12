@extends('maintenance::layouts.pages.main.tabbed')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.inventory.index') }}">
            <i class="fa fa-dropbox"></i>
            Inventory
        </a>
    </li>
    <li class="active">
        {{ $item->name }}
    </li>
@stop

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_calendar" data-toggle="tab">Calendar</a></li>
    <li><a href="#tab_notes" data-toggle="tab">Notes</a></li>
    <li><a href="#tab_history" data-toggle="tab">History</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab_profile">

        {{ $item->viewer()->btnQrCode }}

        {{ $item->viewer()->btnEvents }}

        {{ $item->viewer()->btnAddStock }}

        {{ $item->viewer()->btnEdit }}

        {{ $item->viewer()->btnDelete }}

        <legend>Profile</legend>

        {{ $item->viewer()->profile }}

        <legend>Current Stocks</legend>

        {{ $item->viewer()->stock }}

    </div>

    <div class="tab-pane" id="tab_calendar">
        {{ $item->viewer()->calendar }}
    </div>

    <div class="tab-pane" id="tab_notes">
        {{ $item->viewer()->notes }}
    </div>

    <div class="tab-pane" id="tab_history">
        {{ $item->viewer()->history }}
    </div>
@stop