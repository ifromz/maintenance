@extends('maintenance::layouts.public')

@section('content')

    {{ HTML::script('packages/stevebauman/maintenance/js/auth/login.js') }}

    <div class="login-box">

        <div class="login-logo">{{ $title }}</div>

        {{
            Form::open(array(
                'url' => route('maintenance.login'),
                'id' => 'maintenance-login'
            ))
        }}

        <div class="login-box-body">
            @if (Session::has('message'))
                <div class="status-message alert alert-{{ Session::get('messageType') }}">
                    {{ Session::get('message') }}
                </div>
            @endif

            <div id="maintenance-login-status"></div>

            <div class="form-group has-feedback">
                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email / Username')) }}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="form-group">
                {{ Form::checkbox('remember', 'true') }} Remember me
            </div>

                <p class="text-center">
                    {{ link_to_route('maintenance.login.forgot-password', 'Forgot Password?') }}
                </p>

                <p class="text-center">
                    {{ link_to_route('maintenance.register', "Don't Have an Account?") }}
                </p>

        </div>

        <div class="form-group">
            <button id="btn-sign-in" type="submit" class="btn btn-primary btn-block btn-flat">Sign in</button>
        </div>

        {{ Form::close() }}
    </div>

@stop