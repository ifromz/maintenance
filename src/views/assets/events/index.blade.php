@extends('maintenance::layouts.main')

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
    Events
</li>
@stop

@section('content')

    <div class="panel panel-default">
    	<div class="panel-heading">
            <div class="btn-toolbar">
                <a href="{{ route('maintenance.assets.events.create', array($asset->id)) }}" class="btn btn-primary pull-left" data-toggle="tooltip" title="Create a new Event">
                    <i class="fa fa-plus"></i>
                    New Event
                </a>
            </div>
        </div>
        
        <div class="panel-body">
        @if($asset->events->count() > 0)
            <table class="table table-striped">
            	<thead>
                    <tr>
                        <th>ID</th>
                    	<th>Title</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>All Day</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($asset->events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                    	<td>{{ $event->title }}</td>
                        <td>{{ $event->start_formatted }}</td>
                        <td>{{ $event->end_formatted }}</td>
                        <td>{{ $event->allDay_label }}</td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                    Action
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('maintenance.assets.events.show', array($asset->id, $event->id)) }}">
                                            <i class="fa fa-search"></i> View Event
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('maintenance.assets.events.edit', array($asset->id, $event->id)) }}">
                                            <i class="fa fa-edit"></i> Edit Event
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            href="{{ route('maintenance.assets.events.destroy', array($asset->id, $event->id)) }}" 
                                            data-method="delete"
                                            data-title="Are you sure?"
                                            data-message="Are you sure you want to delete this event? Deleting this event will also remove all recurrences."
                                            >
                                            <i class="fa fa-trash-o"></i> Delete Event
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
        	<p>There are no events to display</p>
        @endif
        </div>
    </div>

@stop