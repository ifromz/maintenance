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
        <i class="fa fa-edit"></i>
        Edit
    </li>
@stop

@section('content')

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Work Order</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array(
                            'url'=>route('maintenance.work-orders.update', array($workOrder->id)),
                            'class'=>'form-horizontal ajax-form-post',
                            'method'=>'PATCH'
                        ))
                }}
                <legend class="margin-top-10">Work Order Information</legend>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>

                    <div class="col-md-4">
                        @include('maintenance::select.work-order-category', array(
                              'category_name'=>($workOrder->category ? $workOrder->category->name : NULL),
                              'category_id'=>($workOrder->category ? $workOrder->category->id : NULL)
                          ))
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Location</label>

                    <div class="col-md-4">
                        @include('maintenance::select.location', array(
                              'location_name'=>($workOrder->location ? $workOrder->location->name : NULL),
                              'location_id' => ($workOrder->location ? $workOrder->location->id : NULL),
                          ))
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Status</label>

                    <div class="col-md-4">
                        @include('maintenance::select.status', array('status'=>$workOrder->status->id))
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Priority</label>

                    <div class="col-md-4">
                        @include('maintenance::select.priority', array('priority'=>$workOrder->priority->id))
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Assets Involved</label>

                    <div class="col-md-4">
                        @include('maintenance::select.assets', array('assets'=>$workOrder->assets->lists('id')))
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Subject</label>

                    <div class="col-md-4">
                        {{ Form::text('subject', $workOrder->subject, array('class'=>'form-control', 'placeholder'=>'ex. Worked on HVAC')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Description / Details</label>

                    <div class="col-md-4">
                        {{ Form::textarea('description', htmlspecialchars($workOrder->description), array('class'=>'form-control', 'style'=>'min-width:100%','placeholder'=>'ex. Added components')) }}
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
    </div>

@stop