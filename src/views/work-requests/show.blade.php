@extends('maintenance::layouts.pages.main.tabbed')

@section('title', 'Viewing Work Request: '.$workRequest->subject)

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_updates" data-toggle="tab">Updates</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab_profile">

        <h2>Profile</h2>

        <div class="col-md-6">
            {!! $workRequest->viewer()->profile() !!}
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="tab-pane" id="tab_updates">

        <legend>Updates</legend>

        {!! $workRequest->viewer()->updates() !!}

    </div>
@stop
