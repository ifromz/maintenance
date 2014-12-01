@extends('maintenance::layouts.pages.main.panel')

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

@section('panel.body.content')
    
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
@stop