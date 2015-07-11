@extends('maintenance::layouts.public')

@section('title', '403 - Permission Denied')

@section('content')

    <div class="login-box">

        <div class="panel panel-danger">
            <div class="panel-heading text-center">
                @yield('title')
            </div>
            <div class="panel-body">
                <p class="text-center">
                    You do not have access to this page.
                </p>

                <a class="btn btn-primary btn-block" href="{{ URL::previous() }}">
                    <i class="fa fa-reply"></i> Go Back
                </a>
            </div>
        </div>

    </div>

@stop
