@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Edit Metric
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url'=>route('maintenance.metrics.update', array($metric->id)),
            'method'=>'PATCH',
            'class'=>'form-horizontal ajax-form-post'
        ))
    }}

    @include('maintenance::metrics.form', compact('metric'))

    {{ Form::close() }}
@stop