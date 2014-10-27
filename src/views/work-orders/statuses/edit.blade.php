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
    <a href="{{ route('maintenance.work-orders.statuses.index') }}">
        <i class="fa fa-exclamation-circle"></i> 
        Statuses
    </a>
</li>
<li class="active">
    <i class="fa fa-info-circle"></i> 
    {{ $status->name }}
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
                <h3 class="panel-title">Edit Status</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(array(
                        'url'=>route('maintenance.work-orders.statuses.update', array($status->id)),
                        'method'=>'PATCH',
                        'class'=>'form-horizontal ajax-form-post clear-form'
                    )) 
            }}
            	<legend class="margin-top-10">Status Information</legend>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-md-4">
                    	{{ Form::text('name', $status->name, array('class'=>'form-control', 'placeholder'=>'ex. Awaiting Parts / Supplies')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Color</label>
                    <div class="col-md-4">
                    	@include('maintenance::select.color', array(
                            'color' => $status->color
                        ))
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