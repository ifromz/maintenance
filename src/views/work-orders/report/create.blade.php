@extends('maintenance::layouts.main')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.work-orders.index') }}">
            <i class="fa fa-book"></i>
            Work Orders
        </a>
    </li>
    <li>
        <a href="{{ route('maintenance.work-orders.show', array($workOrder->id)) }}">
            {{ $workOrder->subject }}
        </a>
    </li>
    <li class="active">
        <i class="fa fa-plus-circle"></i>
        Create Report
    </li>
@stop

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading">
            <h3 class="panel-title">Creating a Report for Work Order: {{ $workOrder->subject }}</h3>
        </div>

        <div class="panel-body">
            {{ Form::open(array(
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
        </div>

    </div>

@stop