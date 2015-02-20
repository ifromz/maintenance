@extends('maintenance::layouts.pages.main.tabbed')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')
    <li>
        <a href="{{ route('maintenance.work-requests.index') }}">
            <i class="fa fa-exclamation-triangle"></i>
            Work Request
        </a>
    </li>
    <li class="active">
        {{ $workRequest->subject }}
    </li>
@stop

@section('tab.head.content')

    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_updates" data-toggle="tab">Updates</a></li>

@stop

@section('tab.body.content')


    <div class="tab-pane active" id="tab_profile">

        <legend>Profile</legend>

        {{ $workRequest->viewer()->profile }}

    </div>

    <div class="tab-pane" id="tab_updates">

        <legend>Updates</legend>

    </div>

@stop