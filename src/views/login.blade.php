@extends('maintenance::layouts.public')

@section('content')
{{ HTML::script('packages/stevebauman/maintenance/js/auth/login.js') }}
<div class="form-box" id="login-box">
    <div class="header bg-light-blue">{{ $title }}</div>
    <form id="maintenance-login" action="{{ route('maintenance.login') }}" method="post">
        <div class="body bg-gray">
            @if (Session::has('message'))
                <div class="status-message alert alert-{{ Session::get('messageType') }}">
                    {{ Session::get('message') }}
                </div>
            @endif

            <div id="maintenance-login-status">
                
            </div>

            <div class="form-group">
                <input type="text" name="email" class="form-control" placeholder="Email / Username"/>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password"/>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" value="true"/> Remember me
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-light-blue btn-block">Sign in</button>
        </div>
    </form>
</div>
@stop