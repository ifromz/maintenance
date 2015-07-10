@extends('maintenance::layouts.client')

@section('title', 'Viewing Work Request')

@section('tab.head.content')
    <li class="active"><a href="#tab_profile" data-toggle="tab">Profile</a></li>
    <li><a href="#tab_updates" data-toggle="tab">Updates</a></li>
@stop

@section('tab.body.content')
    <div class="tab-pane active" id="tab_profile">

        <a href="{{ route('maintenance.work-requests.edit', [$workRequest->id]) }}" class="btn btn-app">
            <i class="fa fa-edit"></i> Edit
        </a>

        <a href="{{ route('maintenance.work-requests.destroy', [$workRequest->id]) }}"
           class="btn btn-app"
           data-method="delete"
           data-token="{{ csrf_token() }}"
           data-message="Are you sure you want to delete this work request? It will be archived.">
            <i class="fa fa-trash-o"></i> Delete
        </a>

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
