@extends('maintenance::layouts.pages.main.panel')


@section('panel.head.content')
    Create a new Work Request
@stop

@section('panel.body.content')
    {{
        Form::open(array(
            'url'=>route('maintenance.work-requests.store'),
            'class'=>'form-horizontal ajax-form-post clear-form'
        ))
    }}

    @include('maintenance::work-requests.form')

    {{ Form::close() }}
@stop