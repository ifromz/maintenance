@extends('maintenance::layouts.main')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')
<div class="col-md-12">
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Add an Item</h3>
            </div>
            <div class="panel-body">
            {{ Form::open(array('url'=>route('maintenance.inventory.store'), 'class'=>'form-horizontal ajax-form-post clear-form')) }}
            	<legend class="margin-top-10">Item Information</legend>
                
                <div class="alert alert-info">
                    Enter the basic item information below. Once the item is created, you will be able to add stock locations to it.
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Category</label>
                    <div class="col-md-4">
                        @include('maintenance::select.category')
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-md-4">
                        {{ Form::text('name', NULL, array('class'=>'form-control', 'placeholder'=>'Name')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-md-4">
                        {{ Form::textarea('description', NULL, array('class'=>'form-control', 'placeholder'=>'Description')) }}
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