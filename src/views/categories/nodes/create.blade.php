@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Create a new Sub-{{ $resource }} for {{ $parent->name }}
@stop

@section('panel.body.content')
    {{
        Form::open([
            'url'=> action(currentControllerAction('store'), [$parent->id]),
            'class'=>'form-horizontal ajax-form-post clear-form'
        ])
    }}

    @include('maintenance::categories.form')

    {{ Form::close() }}
@stop