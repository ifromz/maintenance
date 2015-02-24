@extends('maintenance::layouts.public')

@section('content')

    {{ HTML::script('packages/stevebauman/maintenance/js/auth/login.js') }}

    <div class="login-box">

        <div class="login-logo">{{ $title }}</div>

        <form id="maintenance-login" action="{{ route('maintenance.login') }}" method="post">
            <div class="login-box-body">
                @if (Session::has('message'))
                    <div class="status-message alert alert-{{ Session::get('messageType') }}">
                        {{ Session::get('message') }}
                    </div>
                @endif

                <div id="maintenance-login-status">

                </div>

                <div class="form-group has-feedback">
                    <input type="text" name="email" class="form-control" placeholder="Email / Username"/>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="remember" value="true"/> Remember me
                </div>
            </div>

            <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign in</button>
            </div>

        </form>
    </div>

@stop