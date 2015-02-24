@extends('maintenance::layouts.pages.main.tabbed')

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_report" data-toggle="tab">Report</a></li>
    <li><a href="#tab_recurrences" data-toggle="tab">Recurrences</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_profile">
        {{ $event->viewer()->btnEdit }}

        {{ $event->viewer()->btnDelete }}

        <hr>

        {{ $event->viewer()->profile }}
    </div>

    <div class="tab-pane" id="tab_report">
        {{ $localEvent->viewer()->report }}
    </div>

    <div class="tab-pane" id="tab_recurrences">
        {{ $event->viewer()->recurrences($recurrences) }}
    </div>

@stop