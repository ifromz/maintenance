@extends('maintenance::layouts.pages.main.panel')

@section('title', "Edit Metric: $metric->name")

@section('panel.head.content')
    Edit Metric
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.metrics.update', [$metric->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal'
        ])
    !!}

    @include('maintenance::metrics.form', compact('metric'))

    {!! Form::close() !!}
@stop
