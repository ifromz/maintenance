@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop


@section('breadcrumb')

@stop

@section('panel.head.content')
    <div class="btn-toolbar">
        <a class="btn btn-primary" href="{{ action(currentControllerAction('create'), array($eventable->id)) }}">
            <i class="fa fa-plus-circle"></i>
            New Event
        </a>
    </div>
@stop

@section('panel.body.content')

    @include('maintenance::events.list', array(
        'events' => $events,
    ))

@stop