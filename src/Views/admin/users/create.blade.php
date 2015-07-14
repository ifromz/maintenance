@extends('maintenance::layouts.pages.admin.panel')

@section('title', 'Create User')

@section('panel.head.content')
Create User
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.admin.users.store'),
            'class' => 'form-horizontal'
        ])
    !!}

    <div class="form-group{{ $errors->first('first_name', ' has-error') }}">
        <label class="col-sm-2 control-label">First Name:</label>

        <div class="col-md-4">
            {!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder' => 'Enter First Name']) !!}

            <span class="label label-danger">{{ $errors->first('first_name', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('last_name', ' has-error') }}">
        <label class="col-sm-2 control-label">Last Name:</label>

        <div class="col-md-4">
            {!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder' => 'Enter Last Name']) !!}

            <span class="label label-danger">{{ $errors->first('last_name', ':message') }}</span>
        </div>
    </div>


    <div class="form-group{{ $errors->first('username', ' has-error') }}">
        <label class="col-sm-2 control-label">Username:</label>

        <div class="col-md-4">
            {!! Form::text('username', null, ['class'=>'form-control', 'placeholder' => 'Enter Username']) !!}

            <span class="label label-danger">{{ $errors->first('username', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('email', ' has-error') }}">
        <label class="col-sm-2 control-label">Email:</label>

        <div class="col-md-4">
            {!! Form::text('email', null, ['class'=>'form-control', 'placeholder' => 'Enter Email']) !!}

            <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('password', ' has-error') }}">
        <label class="col-sm-2 control-label">Password:</label>

        <div class="col-md-4">
            {!! Form::password('password', ['class'=>'form-control', 'placeholder' => 'Enter Password']) !!}

            <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('password_confirmation', ' has-error') }}">
        <label class="col-sm-2 control-label">Confirm Password:</label>

        <div class="col-md-4">
            {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder' => 'Confirm Above Password']) !!}

            <span class="label label-danger">{{ $errors->first('password_confirmation', ':message') }}</span>
        </div>
    </div>


    <div class="form-group{{ $errors->first('routes', ' has-error') }}">
        <label class="col-sm-2 control-label">Permissions:</label>

        <div class="col-md-4">
            @include('maintenance::select.routes')

            <span class="label label-danger">{{ $errors->first('routes', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('roles', ' has-error') }}">
        <label class="col-sm-2 control-label">Roles:</label>

        <div class="col-md-4">
            @include('maintenance::select.roles')

            <span class="label label-danger">{{ $errors->first('roles', ':message') }}</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Activated:</label>

        <div class="col-md-2">

            <div class="checkbox">
                <label>
                    {!! Form::checkbox('activated', '1') !!}
                </label>
            </div>

        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
        </div>
    </div>

    {!! Form::close() !!}
@stop
