@extends('maintenance::layouts.pages.main.panel')

@section('title')
<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('panel.head.content')
<h3 class="panel-title">Edit Event</h3>
@stop

@section('panel.body.content')

    {{ Form::open(array(
                'url'=>route('maintenance.events.update', array($event->id)),
                'method' => 'PATCH',
                'class'=>'form-horizontal ajax-form-post'
            )) 
    }}
    
    {{ $event->viewer()->recurrenceWarning }}
    
    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Title / Summary</label>
        <div class="col-md-4">
            {{ Form::text('title', $event->title, array('class'=>'form-control', 'placeholder'=>'Enter Title')) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Description</label>
        <div class="col-md-4">
            {{ Form::text('description', $event->description, array('class'=>'form-control', 'placeholder'=>'Enter Description')) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Start Date & Time</label>
        <div class="col-md-2">
            @include('maintenance::select.date', array(
                'name' => 'start_date',
                'value' => $event->viewer()->startDateFormatted,
            ))
        </div>
        <div class="col-md-2">
            @include('maintenance::select.time', array(
                'name' => 'start_time',
                'value' => $event->viewer()->startTimeFormatted,
            ))
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">End Date & Time</label>
        <div class="col-md-2">
            @include('maintenance::select.date', array(
                'name' => 'end_date',
                'value' => $event->viewer()->endDateFormatted,
            ))
        </div>
        <div class="col-md-2">
            @include('maintenance::select.time', array(
                'name' => 'end_time',
                'value' => $event->viewer()->endTimeFormatted,
            ))
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">All Day</label>
        <div class="col-md-4">
            {{ Form::checkbox('all_day', 'true', $event->all_day, array('class'=>'form-control')) }}
            <br>
        </div>
    </div>
        
    @if(!$event->isRecurrence)
    <div class="form-group">
        <div class="col-md-4 col-md-offset-2">
            <div class="alert alert-warning">
                <p>
                    <b>Heads Up!</b> Setting a new frequency will change the dates and times of all events in the series. 
                    If you've modified a recurrence, it's not recommended to change the recurrence options.
                </p>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Frequency</label>
        <div class="col-md-4">
            @include('maintenance::select.recur_frequency', array(
                'frequency' => $event->viewer()->recurFrequency
            ))
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Specific Days</label>
        <div class="col-md-4">
            @include('maintenance::select.recur_days', array(
                'days' => $event->viewer()->recurDays
            ))
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">Secific Months</label>
        <div class="col-md-4">
            @include('maintenance::select.recur_months')
        </div>
    </div>
    @endif
    
    <div class="form-group">
        <div class="col-md-4 col-md-offset-2">
            {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
        </div>
    </div>
    
    {{ Form::close() }}

@stop