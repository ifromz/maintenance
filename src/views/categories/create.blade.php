@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create {{ $resource }}
@stop

@section('panel.body.content')
    {{
        Form::open([
            'url'=>action(currentControllerAction('store')),
            'class'=>'form-horizontal ajax-form-post clear-form'
        ])
    }}

    @include('maintenance::categories.form')

    {{ Form::close() }}
@stop
