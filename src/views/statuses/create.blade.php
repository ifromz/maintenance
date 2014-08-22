@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
	<script type="text/javascript" src="{{ asset('packages/stevebauman/maintenance/js/statuses/create.js') }}"></script>
	<div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new Status</h3>
            </div>
            <div class="panel-body">
                <legend class="margin-top-10">Status Information</legend>
                {{ Form::open(array(
                        'url'=>route('maintenance.statuses.store'), 
                        'id'=>'maintenance-status-create', 
                        'class'=>'form-horizontal'
                    )) 
               	}}
            
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Name</label>
                    <div class="col-md-4">
                    	{{ Form::text('name', NULL, array('class'=>'form-control', 'placeholder'=>'ex. Completed / Awaiting Parts')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_icon">Select Color</label>
                    <div class="col-md-4">{{ Form::select('color', $colors,  NULL, array('id'=>'color-select', 'class'=>'form-control')) }}</div>
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