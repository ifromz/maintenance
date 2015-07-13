@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Create Event')

@section('panel.head.content')
    Create Event
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route($routes['store'], [$eventable->id]),
            'class'=>'form-horizontal',
        ])
    !!}

    @include('maintenance::events.form')

    {!! Form::close() !!}

@stop
