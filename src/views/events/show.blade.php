@extends('maintenance::layouts.pages.main.tabbed')

@section('title', "Viewing Event: $apiObject->title")

@section('tab.head.content')
    <li class="active"><a href="#tab-profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab-report" data-toggle="tab">Report</a></li>
    <li><a href="#tab-recurrences" data-toggle="tab">Recurrences</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab-profile">
        {!! $event->viewer()->btnEdit(route('maintenance.events.edit', [$event->id])) !!}

        {!! $event->viewer()->btnDelete(route('maintenance.events.destroy', [$event->id])) !!}

        <hr>

        {!! $event->viewer()->profile($apiObject) !!}
    </div>

    <div class="tab-pane" id="tab-report">
        {!! $event->viewer()->report() !!}
    </div>

    <div class="tab-pane" id="tab-recurrences">
        {!! $event->viewer()->recurrences() !!}
    </div>

@stop
