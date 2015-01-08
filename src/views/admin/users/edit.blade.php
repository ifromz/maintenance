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
                    <label class="col-sm-2 control-label">Username</label>

                    <div class="col-md-4">
                        {{ Form::text('username', $user->email, array('class'=>'form-control')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>

                    <div class="col-md-4">
                        {{ Form::text('email', $user->email, array('class'=>'form-control')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">First Name</label>

                    <div class="col-md-4">
                        {{ Form::text('first_name', $user->first_name, array('class'=>'form-control')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Last Name</label>

                    <div class="col-md-4">
                        {{ Form::text('last_name', $user->last_name, array('class'=>'form-control')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Update Password</label>

                    <div class="col-md-4">
                        {{ Form::password('password', array('class'=>'form-control')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Confirm Update Password</label>

                    <div class="col-md-4">
                        {{ Form::password('password_confirmation', array('class'=>'form-control')) }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Activated</label>

                    <div class="col-md-4">
                        {{ Form::checkbox('activate', '1', $user->activated) }}
                    </div>
                </div>

                <div class="alert alert-info">
                    Here you can enter user specific permissions. Permissions here will override permissions in groups.
                    This is useful if a user needs some specific permissions for access.
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">User Specific Permissions</label>

                    <div class="col-md-4">
                        @include('maintenance::select.routes', array(
                            'routes'=>$user->permissions
                        ))
                    </div>
                </div>


                {{ Form::close() }}
            </div>

        </div>
    </div>

@stop