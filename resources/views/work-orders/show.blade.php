@extends('layouts.pages.main.tabbed')

@section('title', "Viewing Work Order")

@section('tab.extra.top')
    @decorator('navbar', $navbar)
@endsection

@section('tab.head.content')
    <li class="active"><a href="#tab-profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab-sessions" data-toggle="tab">Sessions</a></li>
    <li><a href="#tab-calendar" data-toggle="tab">Calendar</a></li>
    <li><a href="#tab-history" data-toggle="tab">History</a></li>
    <li><a href="#tab-updates" data-toggle="tab">Updates</a></li>
@endsection

@section('tab.body.content')

    <div class="tab-pane active" id="tab-profile">

        <div class="row">

            <div class="col-md-6">
                <h2>Work Order Profile</h2>

                @include('work-orders._profile')
            </div>

            <div class="col-md-6">
                <h2>Maintenance Request</h2>

                {!! $workOrder->viewer()->workRequest() !!}

                <hr>

                <h2>Completion Report</h2>

                {!! $workOrder->viewer()->report() !!}
            </div>

        </div>
    </div>

    <div class="tab-pane" id="tab-sessions">

        <h2>Sessions</h2>

        {!! $sessions !!}

    </div>

    <div class="tab-pane" id="tab-calendar">

        {!! $workOrder->viewer()->calendar() !!}

    </div>

    <div class="tab-pane" id="tab-history">

        {!! $history !!}

    </div>

    <div class="tab-pane" id="tab-updates">

        <h2>Updates</h2>

        {!! $workOrder->viewer()->updates() !!}
    </div>

@endsection
