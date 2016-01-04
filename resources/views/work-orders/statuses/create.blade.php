@extends('layouts.pages.main.panel')

@section('title', 'Create a Status')

@section('panel.head.content')
    Create a new Status
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route('maintenance.work-orders.statuses.store'),
            'class' => 'form-horizontal'
        ])
    !!}

    @include('work-orders.statuses.form')

    {!! Form::close() !!}
@stop
