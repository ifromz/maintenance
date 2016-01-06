@extends('layouts.pages.main.tabbed')

@section('title', "Viewing Work Order")

@section('tab.extra.top')
    @decorator('navbar', $navbar)
@stop

@section('tab.head.content')
    <li class="active"><a href="#tab-profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab-details" data-toggle="tab">Details</a></li>
    <li><a href="#tab-calendar" data-toggle="tab">Calendar</a></li>
    <li><a href="#tab-history" data-toggle="tab">History</a></li>
    <li><a href="#tab-updates" data-toggle="tab">Updates</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab-profile">

        <div class="row">

            <div class="col-md-6">
                <h2>Work Order Profile</h2>

                {!! $workOrder->viewer()->profile() !!}
            </div>

            <div class="col-md-6">
                <h2>Maintenance Request</h2>

                {!! $workOrder->viewer()->workRequest() !!}
            </div>

        </div>
    </div>

    <div class="tab-pane" id="tab-details">

        <h2>Completion Report</h2>

        {!! $workOrder->viewer()->report() !!}

        <h2>Sessions</h2>

        {!! $sessions !!}

    </div>

    <div class="tab-pane" id="tab-calendar">

        {!! $workOrder->viewer()->calendar() !!}

    </div>

    <div class="tab-pane" id="tab-history">

        {!! $workOrder->viewer()->history() !!}

    </div>

    <div class="tab-pane" id="tab-updates">

        <h2>Updates</h2>

        {!! $workOrder->viewer()->updates() !!}
    </div>

@stop
