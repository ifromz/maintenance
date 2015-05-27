@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create Event
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.events.store'),
            'class' => 'form-horizontal ajax-form-post clear-form'
        ])
    !!}

    @include('maintenance::events.form')

    {!! Form::close() !!}
@stop
