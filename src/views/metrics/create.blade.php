@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create a new Metric
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url'=>route('maintenance.metrics.store'),
            'class'=>'form-horizontal ajax-form-post clear-form'
        ))
    }}

    @include('maintenance::metrics.form')

    {{ Form::close() }}
@stop
