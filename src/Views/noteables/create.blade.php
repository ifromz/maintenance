@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    <h3 class="panel-title">
        Create Note
    </h3>
@stop

@section('panel.body.content')
    {!!
        Form::open([
            'url' => action(currentControllerAction('store'), [$noteable->id]),
            'class' => 'form-horizontal ajax-form-post clear-form'
        ])
    !!}

    @include('maintenance::noteables.form')

    {!! Form::close() !!}
@stop
