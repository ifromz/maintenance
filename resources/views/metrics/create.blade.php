@extends('layouts.pages.main.panel')

@section('title', 'Create a Metric')

@section('panel.head.content')
    Create a new Metric
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.metrics.store'),
            'class' => 'form-horizontal'
        ])
    !!}

    @include('metrics.form')

    {!! Form::close() !!}
@stop
