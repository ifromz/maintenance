@extends('layouts.pages.admin.tabbed')

@section('title', 'Viewing User')

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
@stop

@section('tab.body.content')

    <div class="tab-pane active" id="tab_profile">

        {!! $user->viewer()->btnUpdatePassword() !!}

        {!! $user->viewer()->btnEdit() !!}

        {!! $user->viewer()->btnDelete() !!}

        <hr>

        {!! $user->viewer()->profile() !!}

        {!! $user->viewer()->permissionChecker() !!}

    </div>

@stop
