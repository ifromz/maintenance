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
                'url'=>action(currentControllerAction('update'), array($eventable->id, $event->id)),
                'method' => 'PATCH',
                'class'=>'form-horizontal ajax-form-post'
            )) 
    }}
        
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
            {{ Form::text('start_date', $event->viewer()->startDateFormatted, array('class'=>'form-control pickadate', 'placeholder'=>'Date')) }}
        </div>
        <div class="col-md-2">
            {{ Form::text('start_time', $event->viewer()->startTimeFormatted, array('class'=>'form-control pickatime', 'placeholder'=>'Time')) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">End Date & Time</label>
        <div class="col-md-2">
            {{ Form::text('end_date', $event->viewer()->endDateFormatted, array('class'=>'form-control pickadate', 'placeholder'=>'Date')) }}
        </div>
        <div class="col-md-2">
            {{ Form::text('end_time', $event->viewer()->endTimeFormatted, array('class'=>'form-control pickatime', 'placeholder'=>'Time')) }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="name">All Day</label>
        <div class="col-md-4">
            {{ Form::checkbox('all_day', 'true', $event->all_day, array('class'=>'form-control')) }}
            <br>
        </div>
    </div>
        
    
    <div class="alert alert-warning">
        <p>Caution: Setting a new frequency will change all events in the series</p>
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

    <div class="form-group">
        <div class="col-md-4 col-md-offset-2">
            {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
        </div>
    </div>
    
    {{ Form::close() }}

@stop