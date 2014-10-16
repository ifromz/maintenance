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
                <h3 class="panel-title">Edit User {{ $user->full_name }}</h3>
            </div>
            
            <div class="panel-body">
                
                {{ Form::open(array(
                        'url'=>route('maintenance.admin.users.update', array($user->id)), 
                        'class'=>'form-horizontal ajax-form-post', 
                        'method'=>'PATCH'
                    )) 
                }}
                
                <div class="form-group">
                    <label class="col-sm-2 control-label">Permissions</label>
                    <div class="col-md-4">
                        
                    </div>
                </div>
                
                
                {{ Form::close() }}
            </div>
            
        </div>
</div>

@stop