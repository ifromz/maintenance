@extends('maintenance::layouts.pages.main.panel')

@section('panel.head.content')
    Add an Item
@stop

@section('panel.body.content')
    @include('maintenance::metrics.modals.create')

    {{
        Form::open(array(
            'url'=>route('maintenance.inventory.store'),
            'class'=>'form-horizontal ajax-form-post clear-form'
        ))
    }}

    @include('maintenance::inventory.form')

    {{ Form::close() }}
@stop