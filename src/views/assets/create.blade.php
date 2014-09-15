@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('content')
	
    {{ HTML::script('packages/stevebauman/maintenance/js/assets/create.js') }}
	 <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create a new Asset</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(array('url'=>route('maintenance.assets.store'), 'class'=>'form-horizontal', 'id'=>'maintenance-asset-create')) }}
            	<legend class="margin-top-10">Required Information</legend>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Name</label>
                    <div class="col-md-4">
                    	{{ Form::text('name', NULL, array('class'=>'form-control', 'placeholder'=>'ex. Ford F150')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Condition</label>
                    <div class="col-md-4">
                    	{{ Form::select('condition', trans('maintenance::assets.conditions'), NULL, array('class'=>'form-control select2')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Category</label>
                    <div class="col-md-4">
                    	@include('maintenance::select.category')
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Location</label>
                    <div class="col-md-4">
                    	@include('maintenance::select.location')
                   	</div>
                </div>
                
                <legend class="margin-top-10">Other Information</legend>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Vendor</label>
                    <div class="col-md-4">
                    	{{ Form::text('vendor', NULL, array('class'=>'form-control', 'placeholder'=>'ex. Ford')) }}
                   	</div>
                </div>
                
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Make</label>
                    <div class="col-md-4">
                    	{{ Form::text('make', NULL, array('class'=>'form-control', 'placeholder'=>'ex. F')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Model</label>
                    <div class="col-md-4">
                    	{{ Form::text('model', NULL, array('class'=>'form-control', 'placeholder'=>'ex. 150')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Size</label>
                    <div class="col-md-4">
                    	{{ Form::text('size', NULL, array('class'=>'form-control', 'placeholder'=>'ex. 1905 x 2463')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Weight</label>
                    <div class="col-md-4">
                    	{{ Form::text('weight', NULL, array('class'=>'form-control', 'placeholder'=>'ex. 1 ton')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Serial</label>
                    <div class="col-md-4">
                    	{{ Form::text('serial', NULL, array('class'=>'form-control', 'placeholder'=>'ex. 153423-13432432-2342423')) }}
                   	</div>
                </div>
                
            	<div class="form-group">
                    <label class="col-sm-2 control-label" for="name">Aquisition Date</label>
                    <div class="col-md-4">
                    	{{ Form::text('aquired_at', NULL, array('class'=>'pickadate form-control', 'placeholder'=>'Click to Select Date')) }}
                   	</div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-2">
                    	{{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
                   	</div>
                </div>
           	</div>
      	</div>
  	</div>
    
@stop