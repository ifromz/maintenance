@extends('maintenance::layouts.admin')

@section('header')
	<h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')

<div class="col-md-12">
        <div class="panel panel-default">
            
            <div class="panel-heading">
                <h3 class="panel-title">Create Group</h3>
            </div>
            
            <div class="panel-body">
                
                {{ Form::open(array(
                        'url'=>route('maintenance.admin.groups.store'), 
                        'class'=>'form-horizontal ajax-form-post clear-form'
                    ))
                }}
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-md-4">
                        {{ Form::text('name', NULL, array('class'=>'form-control', 'placeholder'=>'ex. Admininistrators')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Users</label>
                    <div class="col-md-4">
                        @include('maintenance::select.users')
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Permissions</label>
                    <div class="col-md-4">
                        @include('maintenance::select.routes')
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