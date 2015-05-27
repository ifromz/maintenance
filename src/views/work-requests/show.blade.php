@extends('maintenance::layouts.pages.main.tabbed')

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_updates" data-toggle="tab">Updates</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab_profile">

        <legend>Profile</legend>

        {!! $workRequest->viewer()->profile() !!}

    </div>

    <div class="tab-pane" id="tab_updates">

        <legend>Updates</legend>

        {!! $workRequest->viewer()->updates() !!}

    </div>
@stop
