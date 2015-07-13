@extends('maintenance::layouts.pages.main.panel')

@section('title', 'All Events')

@section('panel.head.content')
    <div class="btn-toolbar">
        <a class="btn btn-primary" href="{{ route($routes['create'], [$eventable->id]) }}">
            <i class="fa fa-plus-circle"></i>
            New Event
        </a>
    </div>
@stop

@section('panel.body.content')



@stop
