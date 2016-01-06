@extends('layouts.public')

@section('title', 'Login')

@section('content')

    <div class="login-box">

        <div class="login-logo">
            <a href="#">
                <b>Maintenance</b> | Login
            </a>
        </div>

        <div class="login-box-body">

            <div class="col-md-12">
                {!! $form !!}
            </div>

            <div class="clearfix"></div>

        </div>

    </div>

@stop
