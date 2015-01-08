@extends('maintenance::layouts.pages.main.tabbed')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.work-orders.index') }}">
            <i class="fa fa-book"></i>
            Work Orders
        </a>
    </li>
    <li class="active">
        {{ $workOrder->subject }}
    </li>
@stop

@section('tab.head.content')

    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_details" data-toggle="tab">Details</a></li>
    <li><a href="#tab_history" data-toggle="tab">History</a></li>
    <li><a href="#tab_parts" data-toggle="tab">Parts / Supplies</a></li>
    <li><a href="#tab_attachments" data-toggle="tab">Attachments</a></li>
    <li><a href="#tab_customer_updates" data-toggle="tab">Customer Updates</a></li>
    <li><a href="#tab_technician_updates" data-toggle="tab">Technician Updates</a></li>

@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_profile">

        <legend>Profile</legend>

        {{ $workOrder->viewer()->btnCheckIn }}

        {{ $workOrder->viewer()->btnEvents }}

        {{ $workOrder->viewer()->btnWorkers }}

        {{ $workOrder->viewer()->btnNotifications }}

        {{ $workOrder->viewer()->btnComplete }}

        {{ $workOrder->viewer()->btnEdit }}

        {{ $workOrder->viewer()->btnDelete }}

        <div class="clearfix"></div>

        <hr>

        {{ $workOrder->viewer()->profile }}

    </div>

    <div class="tab-pane" id="tab_details">

        {{ $workOrder->viewer()->report }}

        {{ $workOrder->viewer()->sessions }}

    </div>

    <div class="tab-pane" id="tab_history">

        {{ $workOrder->viewer()->history }}

    </div>

    <div class="tab-pane" id="tab_parts">

        <legend>Parts / Supplies</legend>

        {{ $workOrder->viewer()->btnAddParts }}

        <hr>

        {{ $workOrder->viewer()->parts }}

    </div>

    <div class="tab-pane" id="tab_attachments">

        <legend>Attachments</legend>

        {{ $workOrder->viewer()->btnAddAttachments }}

        <hr>

        {{ $workOrder->viewer()->attachments }}
    </div>

    <div class="tab-pane" id="tab_customer_updates">

        <legend>Customer Updates</legend>

        {{ $workOrder->viewer()->customerUpdates }}
    </div>

    <div class="tab-pane" id="tab_technician_updates">

        <legend>Technician Updates</legend>

        {{ $workOrder->viewer()->technicianUpdates }}
    </div>

@stop

@section('tab.extra.bottom')



@stop
