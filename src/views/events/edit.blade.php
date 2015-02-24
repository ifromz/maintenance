@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit Event
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url'=>route('maintenance.events.update', array($event->id)),
            'method' => 'PATCH',
            'class'=>'form-horizontal ajax-form-post'
        ))
    }}

    @include('maintenance::events.form', array(
        'event' => $event
    ))

    {{ Form::close() }}
@stop