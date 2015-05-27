@extends('maintenance::layouts.pages.admin.panel')

@section('panel.head.content')
    Create User
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.admin.users.store'),
            'class' => 'form-horizontal ajax-form-post clear-form'
        ])
    !!}

    <div class="form-group">
        <label class="col-sm-2 control-label">First Name:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-info"></i>
                </div>

                {!! Form::text('first_name', null, ['class'=>'form-control', 'placeholder' => 'Enter First Name']) !!}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Last Name:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-info"></i>
                </div>

                {!! Form::text('last_name', null, ['class'=>'form-control', 'placeholder' => 'Enter Last Name']) !!}

            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">Username:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                </div>

                {!! Form::text('username', null, ['class'=>'form-control', 'placeholder' => 'Enter Username']) !!}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-envelope-o"></i>
                </div>

                {!! Form::text('email', null, ['class'=>'form-control', 'placeholder' => 'Enter Email']) !!}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Password:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </div>

                {!! Form::password('password', ['class'=>'form-control', 'placeholder' => 'Enter Password']) !!}

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Confirm Password:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-lock"></i>
                </div>

                {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder' => 'Confirm Above Password']) !!}

            </div>
        </div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">Permissions:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-key"></i>
                </div>

                @include('maintenance::select.routes')

            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Groups:</label>

        <div class="col-md-4">
            <div class="input-group">

                <div class="input-group-addon">
                    <i class="fa fa-users"></i>
                </div>

                @include('maintenance::select.groups')

            </div>
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
