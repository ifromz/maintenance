@extends('maintenance::layouts.pages.admin.panel')

@section('title', 'Edit User')

@section('panel.head.content')
Edit User
@stop

@section('panel.body.content')

    @if(Sentry::getUser()->id === $user->id)
        <div class="alert alert-warning">
            Heads up! You're editing yourself. Changing your username or email can cause your session to expire,
            or you could accidentally remove yourself from administration privileges if you edit permissions, groups or activation.

            Edit with severe caution!
        </div>
    @endif

    {!!
        Form::open([
            'url' => route('maintenance.admin.users.update', [$user->id]),
            'class' => 'form-horizontal',
            'method' => 'PATCH'
        ])
    !!}

    <div class="form-group{{ $errors->first('first_name', ' has-error') }}">
        <label class="col-sm-2 control-label">First Name:</label>

        <div class="col-md-4">
            {!! Form::text('first_name', (isset($user) ? $user->first_name : null), ['class'=>'form-control', 'placeholder' => 'Enter First Name']) !!}

            <span class="label label-danger">{{ $errors->first('first_name', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('last_name', ' has-error') }}">
        <label class="col-sm-2 control-label">Last Name:</label>

        <div class="col-md-4">
            {!! Form::text('last_name', (isset($user) ? $user->last_name : null), ['class'=>'form-control', 'placeholder' => 'Enter Last Name']) !!}

            <span class="label label-danger">{{ $errors->first('last_name', ':message') }}</span>
        </div>
    </div>


    <div class="form-group{{ $errors->first('username', ' has-error') }}">
        <label class="col-sm-2 control-label">Username:</label>

        <div class="col-md-4">
            {!! Form::text('username', (isset($user) ? $user->username : null), ['class'=>'form-control', 'placeholder' => 'Enter Username']) !!}

            <span class="label label-danger">{{ $errors->first('username', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('email', ' has-error') }}">
        <label class="col-sm-2 control-label">Email:</label>

        <div class="col-md-4">
            {!! Form::text('email', (isset($user) ? $user->email : null), ['class'=>'form-control', 'placeholder' => 'Enter Email']) !!}

            <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('routes', ' has-error') }}">
        <label class="col-sm-2 control-label">Permissions:</label>

        <div class="col-md-4">
            @include('maintenance::select.routes', [
                'routes' => (isset($user) ? $user->permissions : null)
            ])

            <span class="label label-danger">{{ $errors->first('routes', ':message') }}</span>
        </div>
    </div>

    <div class="form-group{{ $errors->first('groups', ' has-error') }}">
        <label class="col-sm-2 control-label">Groups:</label>

        <div class="col-md-4">
            @include('maintenance::select.groups', [
                'groups' => (isset($user) ? $user->groups->lists('id', 'name')->toArray() : [])
            ])

            <span class="label label-danger">{{ $errors->first('groups', ':message') }}</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Activated:</label>

        <div class="col-md-2">

            <div class="checkbox">
                <label>
                    {!! Form::checkbox('activated', '1', (isset($user) ? $user->activated : null)) !!}
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
