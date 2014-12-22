@extends('maintenance::layouts.pages.main.panel')

@section('header')
<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('panel.head.content')
<h3 class="panel-title">Create Event</h3>
@stop

@section('panel.body.content')
    
    {{ Form::open(array('url'=>route('maintenance.events.store'), 'class'=>'form-horizontal ajax-form-post clear-form')) }}
        
        <legend>Event Details</legend>
    
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Title / Summary</label>
            <div class="col-md-4">
                {{ Form::text('title', NULL, array('class'=>'form-control', 'placeholder'=>'Enter Title')) }}
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Description</label>
            <div class="col-md-4">
                {{ Form::text('description', NULL, array('class'=>'form-control', 'placeholder'=>'Enter Description')) }}
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Start Date & Time</label>
            
            <div class="col-md-2">
                @include('maintenance::select.date', array(
                    'name' => 'start_date'
                ))
            </div>
            
            <div class="col-md-2">
                @include('maintenance::select.time', array(
                    'name' => 'start_time'
                ))
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">End Date & Time</label>
            <div class="col-md-2">
                @include('maintenance::select.date', array(
                    'name' => 'end_date'
                ))
            </div>
            <div class="col-md-2">
                @include('maintenance::select.time', array(
                    'name' => 'end_time'
                ))
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Attendees</label>
            <div class="col-md-4">
                @include('maintenance::select.users')
            </div>
        </div>
    
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">All Day</label>
            <div class="col-md-4">
                {{ Form::checkbox('all_day', 'true', NULL, array('class'=>'form-control')) }}
            </div>
        </div>
        
        <legend>Recurrence Options</legend>
    
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Frequency</label>
            <div class="col-md-4">
                @include('maintenance::select.recur_frequency')
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Specific Days</label>
            <div class="col-md-4">
                @include('maintenance::select.recur_days')
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Secific Months</label>
            <div class="col-md-4">
                @include('maintenance::select.recur_months')
            </div>
        </div>
    
        <legend>Attach Objects / Items</legend>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Assets</label>
            <div class="col-md-4">
                @include('maintenance::select.assets')
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Work Orders</label>
            <div class="col-md-4">
                @include('maintenance::select.work-orders')
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Inventory</label>
            <div class="col-md-4">
                @include('maintenance::select.inventories')
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-md-4 col-md-offset-2">
                {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
            </div>
        </div>
    
    {{ Form::close() }}

@stop