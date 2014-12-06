@extends('maintenance::layouts.pages.main.tabbed')

@section('header')
<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('panel.head.content')

<div class="btn-toolbar">
    <a href="{{ route('maintenance.assets.calendars.events.create', array($asset->id, $calendar->id)) }}" class="btn btn-primary pull-left" data-toggle="tooltip" title="Create a new Event">
        <i class="fa fa-plus"></i>
        New Event
    </a>
</div>

@stop

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_calendar" data-toggle="tab">Calendar</a></li>
@stop
    
@section('tab.body.content')
    
    <div class="tab-pane active" id="tab_profile">
        
        {{ $calendar->viewer()->profile }}
        
        <legend>Events for this Calendar</legend>
        
        @if($calendar->events->count() > 0)

        {{ $calendar->events
                    ->columns(array(
                        'id' => 'ID',
                        'title' => 'Title',
                        'start_formatted' => 'Start',
                        'end_formatted' => 'End',
                        'allDay_label' => 'All Day',
                        'action' => 'Action',
                    ))
                    ->modify('action', function($event) use($asset, $calendar){
                        return $event->viewer()->btnActionsForAssetCalendar($asset, $calendar);
                    })
                    ->render() 
        }}

        @else

        <h5>There are no events to display.</h5>

        @endif
    </div>

    <div class="tab-pane" id="tab_calendar"></div>
@stop