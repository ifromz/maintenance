@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('panel.head.content')
    <h3 class="panel-title">
        Edit Event
    </h3>
@stop

@section('panel.body.content')

    {{ Form::open(array(
            'url'=>action(currentControllerAction('update'), array($eventable->id, $event->id)),
            'method' => 'PATCH',
            'class'=>'form-horizontal ajax-form-post'
        ))
    }}

    @include('maintenance::events.form', array(
        'event' => $event
    ))

    {{ Form::close() }}

@stop