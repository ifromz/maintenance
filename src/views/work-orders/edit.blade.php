@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
<li class="active">
    <i class="fa fa-book"></i> 
    Work Orders
</li>
@stop

@section('content')

    <script src="/packages/stevebauman/maintenance/js/work-orders/edit.js"></script>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Work Order</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(array('url'=>route('maintenance.work-orders.update', array($workOrder->id)), 'class'=>'form-horizontal', 'method'=>'PATCH', 'id'=>'maintenance-work-order-edit')) }}
            	<legend class="margin-top-10">Work Order Information</legend>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-md-4">
                      	@include('maintenance::select.work-order-category', array(
                                'category_name'=>$workOrder->category->name,
                                'category_id'=>$workOrder->category->id
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
                    	@include('maintenance::select.status', array('status'=>$workOrder->status))
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Priority</label>
                    <div class="col-md-4">
                    	@include('maintenance::select.priority', array('priority'=>$workOrder->priority))
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
                
                <legend class="margin-top-10">Other Information</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Start Date</label>
                    <div class="col-md-4">
                    	<div class="col-md-6">
                        	{{ Form::text('started_at_date', $dates['started']['date'], array('class'=>'form-control pickadate', 'placeholder'=>'Choose Date')) }}
                      	</div>
                        <div class="col-md-6">
                        	{{ Form::text('started_at_time', $dates['started']['time'], array('class'=>'form-control pickatime', 'placeholder'=>'Choose Time')) }}
                       	</div>
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Completion Date</label>
                    <div class="col-md-4">
                    	<div class="col-md-6">
                    		{{ Form::text('completed_at_date', $dates['completed']['date'], array('class'=>'form-control pickadate', 'placeholder'=>'Choose Date')) }}
                      	</div>
                        
                        <div class="col-md-6">
                        	{{ Form::text('completed_at_time', $dates['completed']['time'], array('class'=>'form-control pickatime', 'placeholder'=>'Choose Time')) }}
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