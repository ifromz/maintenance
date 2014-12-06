@extends('maintenance::layouts.pages.main.tabbed')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('tab.head.content')
        <li class="active"><a href="#tab_event" data-toggle="tab">Profile</a></li>
        <li><a href="#tab_recurrences" data-toggle="tab">Recurrences</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_event">
        {{ $event->viewer()->btnEditForAssetCalendar($asset, $calendar) }}
        
        {{ $event->viewer()->btnDeleteForAssetCalendar($asset, $calendar) }}
        <hr>
        
        {{ $event->viewer()->profile }}
    </div>
    <div class="tab-pane" id="tab_recurrences">
        
        @if($recurrences->count() > 0)
        
        <div id="resource-paginate">
        {{ $recurrences->columns(array(
                        'start_formatted' => 'Start',
                        'end_formatted' => 'End',
                        'allDay_label' => 'All Day',
                        'action' => 'Action',
                    ))
                    ->showPages()
                    ->render() }}
        </div>
        
        @else
        <h5>There are no recurrences for this event to list.</h5>
        @endif
        
    </div>

@stop