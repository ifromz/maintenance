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
<li class="active">
    <i class="fa fa-plus-circle"></i> 
    Create
</li>
@stop

@section('content')

    <script src="/packages/stevebauman/maintenance/js/work-orders/create.js"></script>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new Work Order</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(array('url'=>route('maintenance.work-orders.store'), 'class'=>'form-horizontal', 'id'=>'maintenance-work-order-create')) }}
            	<legend class="margin-top-10">Work Order Information</legend>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Category</label>
                    <div class="col-md-4">
                      	@include('maintenance::select.work-order-category')
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Location</label>
                    <div class="col-md-4">
                      	@include('maintenance::select.location')
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="status_name">Status</label>
                    <div class="col-md-4">
                    	@include('maintenance::select.status')
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Priority</label>
                    <div class="col-md-4">
                    	@include('maintenance::select.priority')
                   	</div>
                </div>
                
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Assets Involved</label>
                    <div class="col-md-4">
                    	@include('maintenance::select.assets')
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Subject</label>
                    <div class="col-md-4">
                    	{{ Form::text('subject', NULL, array('class'=>'form-control', 'placeholder'=>'ex. Worked on HVAC')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Description / Details</label>
                    <div class="col-md-4">
                    	{{ Form::textarea('description', NULL, array('class'=>'form-control', 'style'=>'min-width:100%', 'placeholder'=>'ex. Added components')) }}
                   	</div>
                </div>
                
                <legend class="margin-top-10">Other Information</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Start Date</label>
                    <div class="col-md-4">
                    	<div class="col-md-6">
                        	{{ Form::text('started_at_date', NULL, array('class'=>'form-control pickadate', 'placeholder'=>'Choose Date')) }}
                      	</div>
                        <div class="col-md-6">
                        	{{ Form::text('started_at_time', NULL, array('class'=>'form-control pickatime', 'placeholder'=>'Choose Time')) }}
                       	</div>
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="location_name">Completion Date</label>
                    <div class="col-md-4">
                    	<div class="col-md-6">
                    		{{ Form::text('completed_at_date', NULL, array('class'=>'form-control pickadate', 'placeholder'=>'Choose Date')) }}
                      	</div>
                        
                        <div class="col-md-6">
                        	{{ Form::text('completed_at_time', NULL, array('class'=>'form-control pickatime', 'placeholder'=>'Choose Time')) }}
                       	</div>
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