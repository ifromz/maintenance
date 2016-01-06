@extends('layouts.public')

@section('title', 'Welcome')

@section('content')

    <div class="login-box">

        <div class="login-logo"><b>Maintenance</b></div>

        <div class="login-box-body">
            <a class="btn btn-block btn-large btn-primary" href="{{ route('maintenance.login.index') }}">Login</a>
        </div>
    </div>

@stop
