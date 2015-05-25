@extends('maintenance::layouts.pages.main.tabbed')

@section('tab.head.content')
    <li class="active"><a href="#tab-profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab-details" data-toggle="tab">Details</a></li>
    <li><a href="#tab-calendar" data-toggle="tab">Calendar</a></li>
    <li><a href="#tab-history" data-toggle="tab">History</a></li>
    <li><a href="#tab-parts" data-toggle="tab">Parts / Supplies</a></li>
    <li><a href="#tab-attachments" data-toggle="tab">Attachments</a></li>
    <li><a href="#tab-updates" data-toggle="tab">Updates</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab-profile">

        <div class="col-md-12">
            <div class="pull-left">
                {{ $workOrder->viewer()->btnCheckIn }}

                {{ $workOrder->viewer()->btnEvents }}

                {{ $workOrder->viewer()->btnWorkers }}

                {{ $workOrder->viewer()->btnNotifications }}

                {{ $workOrder->viewer()->btnComplete }}

            </div>

            <div class="pull-right">
                {{ $workOrder->viewer()->btnEdit }}

                {{ $workOrder->viewer()->btnDelete }}
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <h2>Profile</h2>

                {{ $workOrder->viewer()->profile }}
            </div>

            <div class="col-md-6">
                <h2>Work Request</h2>

                {{ $workOrder->viewer()->workRequest }}
            </div>

        </div>
    </div>

    <div class="tab-pane" id="tab-details">

        {{ $workOrder->viewer()->report }}

        {{ $workOrder->viewer()->sessions($sessions) }}

    </div>

    <div class="tab-pane" id="tab-calendar">

        {{ $workOrder->viewer()->calendar }}

    </div>

    <div class="tab-pane" id="tab-history">

        {{ $workOrder->viewer()->history }}

    </div>

    <div class="tab-pane" id="tab-parts">

        {{ $workOrder->viewer()->btnAddParts }}

        <h2>Parts / Supplies</h2>

        {{ $workOrder->viewer()->parts }}

    </div>

    <div class="tab-pane" id="tab-attachments">

        {{ $workOrder->viewer()->btnAddAttachments }}

        <h2>Attachments</h2>

        {{ $workOrder->viewer()->attachments }}
    </div>

    <div class="tab-pane" id="tab-updates">

        <h2>Updates</h2>

        {{ $workOrder->viewer()->updates }}
    </div>
@stop
