@extends('layouts.pages.main.panel')

@section('title', 'Create Report')

@section('panel.head.content')
    Create Report
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.work-orders.report.store', [$workOrder->id]),
            'class' => 'form-horizontal',
        ])
    !!}

    <legend>Enter Details</legend>

    <div class="form-group{{ $errors->first('status', ' has-error') }}">
        <label class="col-sm-2 control-label">Change Status To</label>

        <div class="col-md-8">
            @include('select.status', [
                'status' => $workOrder->status->id
            ])

            <span class="label label-danger">{{ $errors->first('status', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('description', ' has-error') }}">
        <label class="col-sm-2 control-label">Description</label>

        <div class="col-md-8">
            {!! Form::textarea('description', null, ['class'=>'form-control']) !!}

            <span class="label label-danger">{{ $errors->first('description', ':message') }}</span>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop
