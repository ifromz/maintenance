@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li>
    <a href="{{ route('maintenance.assets.index') }}">
        <i class="fa fa-truck"></i> 
        Assets
    </a>
</li>
<li>
    <a href="{{ route('maintenance.assets.show', array($asset->id)) }}">
        {{ $asset->name }}
    </a>
</li>
<li class="active">
    <i class="fa fa-calendar"></i>
    Calendars
</li>
@stop

@section('panel.head.content')

<div class="btn-toolbar">

    <a href="{{ route('maintenance.assets.calendars.create', array($asset->id)) }}" 
       class="btn btn-primary pull-left" 
       data-toggle="tooltip" 
       title="Create a new Calendar">
        <i class="fa fa-plus"></i>
        New Calendar
    </a>

</div>

@stop

@section('panel.body.content')
    
    @if($asset->calendars->count() > 0)
    
    <div id="resource-paginate">
        {{ $asset->calendars->columns(array(
                    'name' => 'Name',
                    'description' => 'Description',
                    'events' => 'Events',
                    'action' => 'Action',
                ))
                ->modify('events', function($calendar){
                    return $calendar->events->count();
                })
                ->modify('action', function($calendar) use ($asset){
                    return $calendar->viewer()->btnActionsForAsset($asset);
                })
                ->render() }}
    </div>
    
    @else
    <h5>There are currently no calendars to display.</h5>
    @endif

@stop