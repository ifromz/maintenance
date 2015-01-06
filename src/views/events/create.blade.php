@extends('maintenance::layouts.pages.main.panel')

@section('header')
    <h1>{{ $title }}</h1>
@stop

@section('breadcrumb')

@stop

@section('panel.head.content')
    <h3 class="panel-title">
        Create Event
    </h3>
@stop

@section('panel.body.content')

    {{
        Form::open(array(
            'url'=>route('maintenance.events.store'),
            'class'=>'form-horizontal ajax-form-post clear-form'
        ))
    }}

    @include('maintenance::events.form')

    {{ Form::close() }}

@stop