@extends('layouts.pages.main.panel')

@section('title', 'Create Priority')

@section('panel.head.content')
    Create a new Priority
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.work-orders.priorities.store'),
            'class' => 'form-horizontal'
        ])
    !!}

    @include('work-orders.priorities.form')

    {!! Form::close() !!}
@stop
