@extends('layouts.pages.main.panel')

@section('title', "Edit Metric: $metric->name")

@section('panel.head.content')
    Edit Metric
@endsection

@section('panel.body.content')
    {!!
        Form::open([
            'url' => route('maintenance.metrics.update', [$metric->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal'
        ])
    !!}

    @include('metrics.form', compact('metric'))

    {!! Form::close() !!}
@endsection
