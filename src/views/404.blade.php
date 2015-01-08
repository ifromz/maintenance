@extends('maintenance::layouts.public')

@section('content')

    <div class="form-box" id="login-box">
        <div class="header bg-yellow">{{ $title }}</div>
        <div class="body bg-gray">
            <p>The page you tried to visit does not exist. </p>
        </div>
    </div>

@stop