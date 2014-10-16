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
                <h3 class="panel-title">Edit Group {{ $group->name }}</h3>
            </div>
            
            <div class="panel-body">
                
                {{ Form::open(array(
                        'url'=>route('maintenance.admin.groups.update', array($group->id)), 
                        'class'=>'form-horizontal ajax-form-post', 
                        'method'=>'PATCH'
                    ))
                }}
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Group Name</label>
                    <div class="col-md-4">
                        {{ Form::text('name', $group->name, array('class'=>'form-control')) }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Users in this Group</label>
                    <div class="col-md-4">
                        @include('maintenance::select.users', array(
                            'users'=>$group->users->lists('id', 'username')
                        ))
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Permissions for this Group</label>
                    <div class="col-md-4">
                        @include('maintenance::select.routes', array(
                            'routes'=>$group->permissions
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