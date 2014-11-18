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
               title="Create a new Asset">
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
                </tr>
            </thead>
            <tbody>
                
                @foreach($asset->calendars as $calendar)
                <tr>
                    <td>{{ $calendar->name }}</td>
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