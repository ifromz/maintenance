@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create Report
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url'=>route('maintenance.work-orders.report.store', array($workOrder->id)),
            'class' => 'form-horizontal ajax-form-post',
        ))
    }}

    <legend>Enter Details</legend>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="location_name">Change Status To</label>

        <div class="col-md-8">
            @include('maintenance::select.status', array(
                'status'=>$workOrder->status->id
            ))
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label" for="location_name">Description</label>

        <div class="col-md-8">
            {{ Form::textarea('description', NULL, array('class'=>'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
        </div>
    </div>

    {{ Form::close() }}
@stop