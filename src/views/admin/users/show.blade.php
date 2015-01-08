@extends('maintenance::layouts.admin')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('content')

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Profile</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                @include('maintenance::admin.users.tabs.profile', array('user'=>$user))
            </div>
        </div>
        <!-- /.tab-content -->
    </div>

@stop