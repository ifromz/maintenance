@extends('maintenance::layouts.public')

@section('content')

    <div class="login-box">

        <div class="panel panel-danger">
            <div class="panel-heading text-center">
                {{ $title }}
            </div>
            <div class="panel-body">
                <p class="text-center">
                    The page you tried to visit does not exist.
                </p>
            </div>
        </div>

    </div>

@stop