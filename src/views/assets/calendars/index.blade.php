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
    Calendars
</li>
@stop

@section('content')

<div class="panel panel-default">
    
    <div class="panel-heading">
        
        <div class="btn-toolbar">
            
            <a href="{{ route('maintenance.assets.calendars.create', array($asset->id)) }}" 
               class="btn btn-primary pull-left" 
               data-toggle="tooltip" 
               title="Create a new Calendar">
                <i class="fa fa-plus"></i>
                New Calendar
            </a>
            
        </div>
        
    </div>
    
    <div class="panel-body">
        
        @if($asset->calendars->count() > 0)
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Events</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($asset->calendars as $calendar)
                <tr>
                    <td>{{ $calendar->name }}</td>
                    <td>{{ str_limit($calendar->description) }}</td>
                    <td>{{ $calendar->events->count() }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Action
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('maintenance.assets.calendars.show', array($asset->id, $calendar->id)) }}">
                                        <i class="fa fa-search"></i> View Calendar
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.assets.calendars.edit', array($asset->id, $calendar->id)) }}">
                                        <i class="fa fa-edit"></i> Edit Calendar
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('maintenance.assets.calendars.destroy', array($asset->id, $calendar->id)) }}" data-method="delete" data-message="Are you sure you want to delete this calendar?">
                                        <i class="fa fa-trash-o"></i> Delete Calendar
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
        <h5>There are currently no calendars to display.</h5>
        @endif
        
    </div>
    
</div>

@stop